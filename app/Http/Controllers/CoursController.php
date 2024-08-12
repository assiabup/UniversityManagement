<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\Cours;
use App\Models\Level;
use App\Models\Module;

use App\Models\FieldOfStudy;
use Illuminate\Http\Request;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CourseSharedNotification;

class CoursController extends Controller
{
    /**
     * Archive the specified course.
     */


    public function restore($id)
    {
        $course = Cours::findOrFail($id);
        $course->archived = false;
        $course->save();

        return redirect()->back()->with('success', 'Le cours a été restauré avec succès.');
    }
    /**
     * Upload and store the PDF file for a course.
     */
    public function upload(Request $request)
    {
        $file = $request->file('file');

        // Assurez-vous de stocker le fichier dans un répertoire approprié
        $filePath = $file->store('public/courses');

        $cours = new Cours();
        $cours->title = $file->getClientOriginalName();
        $cours->file_path = $filePath;
        $cours->module_id = $request->module_id;
        $cours->save();

        // Redirigez l'utilisateur ou affichez un message de succès
        return redirect()->route('salam')->with('success', 'Cours importé avec succès.');
    }

    public function index()
    {
        $modules = Module::all(); // Cela suppose que vous avez un modèle Module défini

        // Passez les modules à la vue
        return view('PDF', compact('modules'));
    }







    public function download($courseId)
    {
        $course = Cours::findOrFail($courseId);

        // Récupération du chemin complet du fichier
        $filePath = storage_path('app/' . $course->file_path);

        // Vérification de l'existence du fichier
        if (file_exists($filePath)) {
            // Téléchargement du fichier
            return response()->download($filePath);
        } else {
            // Gestion de l'erreur si le fichier n'est pas trouvé
            abort(404, 'File not found');
        }
    }
    public function loadModuleCourses(Request $request)
    {
        $moduleId = $request->input('module_id');
        $module = Module::findOrFail($moduleId);

        $courses = $module->courses;

        return view('partials.module_courses', [
            'courses' => $courses,
        ]);
    }
    public function show4($moduleId)
    {
        // Récupérer le module par son ID
        $module = Module::findOrFail($moduleId);

        // Récupérer les cours associés à ce module
        $cours = Cours::where('module_id', $moduleId)->get();

        // Retourner la vue avec les cours
        return view('cours_show', compact('module', 'cours'));
    }

    // Afficher le formulaire d'ajout de cours pour un module
    public function create4($moduleId)
    {
        // Récupérer le module par son ID
        $module = Module::findOrFail($moduleId);

        // Retourner la vue du formulaire d'ajout de cours
        return view('cours_create', compact('module'));
    }

    // Enregistrer un nouveau cours pour un module

    public function store4(Request $request, $moduleId)
    {
        try {
            // Validation des données du formulaire
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'pdf_file' => 'required|file|mimes:pdf|max:2048',
                'type' => 'required|string|max:255',
            ]);
    
            // Enregistrement du fichier PDF dans le dossier 'cours_pdfs' du disque local
            $pdfPath = $request->file('pdf_file')->store('cours_pdfs');
    
            // Récupération du module associé
            $module = Module::findOrFail($moduleId);
    
            // Création d'un nouveau cours pour le module spécifié
            $cours = new Cours();
            $cours->title = $validatedData['title'];
            $cours->file_path = $pdfPath; // Chemin du fichier PDF
            $cours->archived = false;
            $cours->type = $validatedData['type']; // Type de cours
    
            // Association du cours au module et aux relations
            $cours->module()->associate($module);
            $cours->field_of_study_id = $module->field_of_study_id;
            $cours->level_id = $module->niveau_id;
    
            // Enregistrement du cours
            $cours->save();
    
            // Redirection avec un message de succès
            return redirect()->route('filiere_niveaux', ['moduleId' => $moduleId])
                ->with('success', 'Cours ajouté avec succès !');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Gérer les erreurs de validation
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Gérer les autres erreurs
            Log::error('Erreur lors de l\'enregistrement du cours : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du cours. Veuillez réessayer.');
        }
    }
    public function destroy($courseId)
    {
        $course = Cours::findOrFail($courseId);

        // Supprimer le fichier du stockage
        $filePath = storage_path('app/' . $course->file_path);
        if (file_exists($filePath)) {
            unlink($filePath); // Supprimer le fichier
        }

        // Supprimer l'enregistrement de la base de données
        $course->delete();

        // Redirection avec un message de succès
        return redirect()->back()->with('success', 'Cours supprimé avec succès');
    }
    public function archive(Request $request, $courseId)
    {
        $course = Cours::findOrFail($courseId);
        $course->archived = true;
        $course->save();

        return redirect()->back()->with('success', 'Le cours a été archivé avec succès.');
    }
    

    public function unarchive(Request $request, $courseId)
    {
        // Récupérer le cours à désarchiver
        $course = Cours::findOrFail($courseId);
    
        // Vérifier si le cours est déjà désarchivé
        if (!$course->archived) {
            return redirect()->back()->with('error', 'Le cours est déjà désarchivé.');
        }
    
        // Désarchiver le cours
        $course->archived = false;
        $course->save();
    
        Log::info('Cours désarchivé: ' . $course->title);
    
        // Récupérer tous les étudiants du niveau associé au cours
        $students = User::whereHas('student', function ($query) use ($course) {
            $query->where('level_id', $course->level_id);
        })
        ->where('role', 'etudiant')
        ->get();
  
        Log::info('Étudiants récupérés: ' . $students->count());
    
        // Créer la notification
        $message = 'Un cour a été publié';
        $notification = UserNotification::create([
            'message' => $message,
            'read' => false,
        ]);
    
        Log::info('Notification créée: ' . $notification->id);
    
        // Associer la notification à chaque étudiant via la table pivot
        foreach ($students as $student) {
            $student->notifications()->attach($notification->id);
            Log::info('Notification associée à l\'étudiant: ' . $student->id);
        }
    
      
    
    return redirect()->back()->with('success', 'Le cours a été désarchivé avec succès et les notifications ont été envoyées aux étudiants.');
}

    /*
    public function showNotifications()
    {
        // Récupérer l'étudiant connecté
        $student = Auth::user();

        // Récupérer toutes les notifications non lues de cet étudiant
        $notifications = UserNotification::where('user_id', $student->id)
            ->where('read', false)
            ->orderBy('created_at', 'desc')
            ->get();

        // Marquer les notifications comme lues une fois récupérées
        foreach ($notifications as $notification) {
            $notification->read = true;
            $notification->save();
        }

        return view('student_notifications', ['notifications' => $notifications]);
    }
    */
    public function showNiveauxFiliere1()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Vérifier si l'utilisateur est un enseignant
        if ($user && $user->role == 2) {
            // Récupérer l'enseignant associé à l'utilisateur
            $teacher = $user->teacher;

            if ($teacher) {
                // Récupérer les filières et les niveaux associés à l'enseignant
                $filieres = [];
                foreach ($teacher->fieldsOfStudy as $fieldOfStudy) {
                    $levels = Level::whereHas('teachers', function ($query) use ($teacher) {
                        $query->where('teachers.id', $teacher->id);
                    })->whereHas('fieldOfStudy', function ($query) use ($fieldOfStudy) {
                        $query->where('field_of_study_id', $fieldOfStudy->id);
                    })->get();

                    $filieres[] = [
                        'teacher' => $teacher,
                        'field_of_study' => $fieldOfStudy,
                        'levels' => $levels
                    ];
                }

                return view('prof_niveaux_filieres', compact('filieres'));
            } else {
                return redirect()->back()->with('error', 'Enseignant introuvable.');
            }
        } else {
            return redirect()->back()->with('error', 'Accès refusé.');
        }
    }
// Afficher les modules d'un niveau et d'une filière
public function showModules1($niveauId, $filiereId)
{
    // Récupérer l'utilisateur authentifié
    $user = Auth::user();

    // Vérifier si l'utilisateur est un professeur
    if (!$user->role ==2) {
        abort(403, 'Unauthorized action.');
    }

    // Récupérer le professeur associé à l'utilisateur
    $teacher = $user->teacher;

    // Vérifier si le professeur existe et est associé à l'utilisateur authentifié
    if (!$teacher) {
        abort(403, 'Unauthorized action.');
    }

    // Récupérer le niveau et la filière associés aux IDs fournis
    $niveau = Level::findOrFail($niveauId);
    $filiere = FieldOfStudy::findOrFail($filiereId);

    // Récupérer les modules associés à ce niveau, cette filière et ce professeur
    $modules = Module::where('niveau_id', $niveauId)
        ->where('field_of_study_id', $filiereId)
        ->whereHas('teachers', function ($query) use ($teacher) {
            $query->where('teachers.id', $teacher->id);
        })
        ->get();

    return view('prof_modules', compact('niveau', 'filiere', 'modules'));
}

// Afficher les cours d'un module
public function show41($moduleId)
{
    $module = Module::findOrFail($moduleId);
    $cours = Cours::where('module_id', $moduleId)->get();

    return view('cours_show1', compact('module', 'cours'));
}

// Afficher le formulaire d'ajout de cours pour un module
public function create41($moduleId)
{
    $module = Module::findOrFail($moduleId);

    return view('cours_create1', compact('module'));
}

// Enregistrer un nouveau cours pour un module
public function store41(Request $request, $moduleId)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'pdf_file' => 'required|file|mimes:pdf|max:2048',
        'type' => 'required|string|max:255',
    ]);

    $pdfPath = $request->file('pdf_file')->store('cours_pdfs');

    try {
        $module = Module::findOrFail($moduleId);
        $cours = new Cours();
        $cours->title = $validatedData['title'];
        $cours->file_path = $pdfPath;
        $cours->archived = false;
        $cours->type = $validatedData['type'];
        $cours->module()->associate($module);
        $cours->field_of_study_id = $module->field_of_study_id;
        $cours->level_id = $module->niveau_id;
        $cours->save();

        return redirect()->route('prof.niveaux-filieres1');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Erreur lors de l\'ajout du cours : ' . $e->getMessage());
    }
}

public function destroy1($courseId)
{
    $course = Cours::findOrFail($courseId);
    $filePath = storage_path('app/' . $course->file_path);
    if (file_exists($filePath)) {
        unlink($filePath);
    }
    $course->delete();

    return redirect()->back()->with('success', 'Cours supprimé avec succès');
}

public function archive1(Request $request, $courseId)
{
    $course = Cours::findOrFail($courseId);
    $course->archived = true;
    $course->save();

    return redirect()->back()->with('success', 'Le cours a été archivé avec succès.');
}

public function unarchive1(Request $request, $courseId)
{
    $course = Cours::findOrFail($courseId);
    if (!$course->archived) {
        return redirect()->back()->with('error', 'Le cours est déjà désarchivé.');
    }
    $course->archived = false;
    $course->save();

    $students = User::whereHas('student', function ($query) use ($course) {
        $query->where('level_id', $course->level_id);
    })
        ->where('role', 'etudiant')
        ->get();

        
    
        // Créer la notification
        $message = 'Un cour a été publié';
        $notification = UserNotification::create([
            'message' => $message,
            'read' => false,
        ]);
    
       
    
        // Associer la notification à chaque étudiant via la table pivot
        foreach ($students as $student) {
            $student->notifications()->attach($notification->id);
            Log::info('Notification associée à l\'étudiant: ' . $student->id);
        }
    
    

    return redirect()->back()->with('success', 'Le cours a été désarchivé avec succès et les notifications ont été envoyées aux étudiants.');
}






}