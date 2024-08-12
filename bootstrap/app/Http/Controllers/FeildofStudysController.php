<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Grade ;
use App\Models\Level ;
use App\Models\Module ;
use App\Models\Student ;
use App\Models\FieldOfStudy;
use Illuminate\Http\Request;
use App\Imports\GradesImport;
use App\Models\Notifications;
use App\Models\UserNotification;
use App\Models\RattrapageStudent;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use  App\Imports\importe_grades_ratt;
use Illuminate\Support\Facades\Validator;


class FeildofStudysController extends Controller
{
    public function index()
    {
        $fieldofstudys = FieldOfStudy::all();

        return view("Filieres")->with([
            'fieldofstudys' => $fieldofstudys
        ]);
    }
    public function store1(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'levels' => 'required|array',
            'levels.*' => 'string|max:255',
            'disription'=>'string|max:255',
        ]);

        // Créer la filière 
        $fieldOfStudy = FieldOfStudy::create([
            'name' => $validatedData['name'],
            'disription'=>$validatedData['disription'],
        ]);

        // Créer les niveaux associés à la filière
        foreach ($validatedData['levels'] as $levelName) {
            $fieldOfStudy->levels()->create([
                'name' => $levelName,
            ]);
        }

        return redirect()->route('filiere_niveaux', $fieldOfStudy->id);
    }

    public function show_forme(){
        return view('forme_Filiere');
    }
    public function showFieldOfStudySelectionForm()
    {
        // Récupérer toutes les filières depuis la base de données
        $fieldOfStudies = FieldOfStudy::all();
    
        return view('select_field_of_study', [
            'fieldOfStudies' => $fieldOfStudies
        ]);
    }
    
    public function showStudentsByFieldOfStudy(Request $request)
    {
        $fieldOfStudyId = $request->input('field_of_study_id');
    
        // Récupérer la filière correspondant à l'ID spécifié
        $fieldOfStudy = FieldOfStudy::find($fieldOfStudyId);
    
        if (!$fieldOfStudy) {
            abort(404); // Gérer le cas où la filière n'est pas trouvée
        }
    
        // Récupérer les étudiants associés à cette filière
        $students = $fieldOfStudy->students;
    
        return view('students_by_field_of_study', [
            'fieldOfStudy' => $fieldOfStudy,
            'students' => $students
        ]);
    }
    //afficher les filiere par le nom
    public function index1()
    {
        // Récupérer toutes les filières
        $fieldOfStudies = FieldOfStudy::all();

        // Grouper les filières par leur nom complet
        $groupedFieldOfStudies = $fieldOfStudies->groupBy('name');

        return view('filiere_groupBy_nom', [
            'groupedFieldOfStudies' => $groupedFieldOfStudies
        ]);
    }
// AFFICHER LES FILIERE PAS NIVEAU 
public function displayFiliereNiveaux()
{
    $filieres = FieldOfStudy::all();// Récupérer toutes les filières avec leurs niveaux

    return view('filiere_niveaux', compact('filieres'));
}

public function index2(){
    // Exemple de récupération des données depuis le modèle Filiere
    $filières = FieldOfStudy::with('levels')->get(); // Assurez-vous que 'levels' est une relation définie dans le modèle Filiere

    return view('filiere_niveaux', ['filières' => $filières]);
}
public function destroy($filiereId)
{
    $filiere =  FieldOfStudy::findOrFail($filiereId);
    $filiere->delete();

    return redirect()->route('filiere_niveaux')->with('success', 'Filière supprimée avec succès.');
}
public function showImportForm(){
    return view('importe6');
   }


public function store6(Request $request)
{
    $file = $request->file('file');

    if ($file) {
        try {
            // Importer le fichier Excel des notes en utilisant la classe GradesImport
            Excel::import(new GradesImport(), $file);
            $data = Excel::toCollection(new GradesImport(), $file);

            // Parcourir les données du fichier Excel
            foreach ($data[0] as $row) {
                $studentCNE = $row['cne'];
                
                // Rechercher l'étudiant dans la base de données par son CNE
                $student = Student::where('cne', $studentCNE)->first();

                // Si l'étudiant est trouvé, enregistrer la notification
                if ($student) {
                    $message = 'Affichage de note';
                    UserNotification::create([
                        'user_id' => $student->user_id,
                        'message' => $message,
                        'read' => false,
                    ]);
                }
            }

            // Rediriger avec un message de succès
            return back()->with('status', 'Le fichier Excel des notes a été importé avec succès et les notifications ont été enregistrées pour les étudiants.');
        } catch (\Exception $e) {
            // Afficher une erreur en cas d'échec de l'importation
            return back()->with('error', 'Une erreur s\'est produite lors de l\'importation du fichier Excel des notes : ' . $e->getMessage());
        }
    } else {
        // Retourner avec un message si aucun fichier n'a été sélectionné
        return back()->with('error', 'Veuillez sélectionner un fichier Excel des notes.');
    }
}

public function store7(Request $request)
{
    $file = $request->file('file');
    
    if ($file) {
        try {
            // Importer le fichier Excel avec la classe d'importation des notes de rattrapage
            Excel::import(new importe_grades_ratt(), $file);
            $data = Excel::toCollection(new importe_grades_ratt(), $file);
             // Parcourir les données du fichier Excel
             foreach ($data[0] as $row) {
                $studentCNE = $row['cne'];
                
                // Rechercher l'étudiant dans la base de données par son CNE
                $student = Student::where('cne', $studentCNE)->first();

                // Si l'étudiant est trouvé, enregistrer la notification
                if ($student) {
                    $message = 'Affichage de note';
                    UserNotification::create([
                        'user_id' => $student->user_id,
                        'message' => $message,
                        'read' => false,
                    ]);
                }
            }

            // Rediriger avec un message de succès
            return back()->with('status', 'Le fichier de notes de rattrapage a été importé avec succès.');
        } catch (\Exception $e) {
            // Afficher une erreur en cas d'échec de l'importation
            return back()->with('error', 'Une erreur s\'est produite lors de l\'importation du fichier de notes de rattrapage : ' . $e->getMessage());
        }
    } else {
        // Retourner avec un message si aucun fichier n'a été sélectionné
        return back()->with('error', 'Veuillez sélectionner un fichier de notes de rattrapage.');
    }
}
    
           
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

public function selectFiliereNiveauForm()
    {
        $filieres = FieldOfStudy::all();
        $niveaux = Level::all();
        return view('selectFiliereNiveau', compact('filieres', 'niveaux'));
    }

    public function showStudentGrades(Request $request)
    {
        $filiereId = $request->input('filiere');
        $niveauId = $request->input('niveau');

        $selectedFiliere = FieldOfStudy::findOrFail($filiereId);
        $selectedNiveau = Level::findOrFail($niveauId);

        // Récupérer les étudiants de la filière et du niveau sélectionnés
        $etudiants = Student::where('field_of_study_id', $filiereId)
            ->where('level_id', $niveauId)
            ->with('grades.module') // Charger les relations grades et module
            ->get();

        return view('showStudentGrades', compact('selectedFiliere', 'selectedNiveau', 'etudiants'));
    }
    public function chooseImportType()
    {
     
    
        return view('chooseImportType');
    }
    

    
      
   
    public function showImportForm1()
    {

        return view('importe_rattrapage');
    }
    public function showRattrapage()
    {
        // Récupérer les notes de rattrapage nécessaires (étudiants qui ont échoué et ont besoin de rattrapage)
        $notesRattrapage = Grade::where('is_pass', false)->where('score', '<', $this->getPassingScore())->get();
        
        return view('notes_rattrapage', ['notesRattrapage' => $notesRattrapage]);
    }
    
    /**
     * Méthode privée pour récupérer le seuil de réussite en fonction de la filière.
     *
     * @return int
     */
    private function getPassingScore()
    {
        // Récupérer le seuil de réussite en fonction de la filière (par exemple, Cycle Préparatoire)
        $fieldOfStudyName = 'Cycle Preparatoire'; // Remplacez par le nom de la filière concernée
        
        // Déterminer le seuil de réussite en fonction du nom de la filière
        switch ($fieldOfStudyName) {
            case 'Cycle Preparatoire':
                return 10; // Seuil de réussite pour le Cycle Préparatoire
            default:
                return 12; // Seuil de réussite par défaut pour les autres filières
        }
    }
    public function chooseDisplay()
    {
        return view('choose_display');
    }
    public function showSelectionForm()
    {
        $fieldOfStudies = FieldOfStudy::all();
        $levels = Level::all();

        return view('final_results_form', compact('fieldOfStudies', 'levels'));
    }

    public function showFinalResults(Request $request)
    {
        $fieldOfStudyId = $request->input('field_of_study_id');
        $levelId = $request->input('level_id');
        $fieldOfStudies = FieldOfStudy::all();
        $levels = Level::all();

        $finalResults = Grade::whereHas('student', function ($query) use ($fieldOfStudyId, $levelId) {
            $query->where('field_of_study_id', $fieldOfStudyId)
                  ->where('level_id', $levelId);
        })->get();

        return view('final_results', compact('finalResults'));
    }
    public function show8(Request $request)
    {
        $fieldOfStudyId = $request->input('field_of_study_id');
        $levelId = $request->input('level_id');

        // Récupérer la filière sélectionnée
        $fieldOfStudy = FieldOfStudy::findOrFail($fieldOfStudyId);

        // Récupérer tous les étudiants de cette filière
        $students = $fieldOfStudy->students;

        // Parcourir les étudiants pour déterminer leur statut de validation
        foreach ($students as $student) {
            $grade = Grade::where('student_id', $student->id)
                          ->where('field_of_study_id', $fieldOfStudyId)
                          ->first();

            $rattrapageStudent = RattrapageStudent::where('student_id', $student->id)
                                                   ->where('field_of_study_id', $fieldOfStudyId)
                                                   ->first();

            if ($fieldOfStudy->name === 'Cycle Préparatoire') {
                if ($grade && $grade->score >= 10) {
                    $student->validated = true;
                } elseif ($grade && $grade->score >= 7 && $grade->score <= 9) {
                    $student->eliminatory = true;
                } else {
                    $student->validated = false;
                }
            } else {
                if ($grade && $grade->score >= 12) {
                    $student->validated = true;
                } elseif ($grade && $grade->score >= 8 && $grade->score <= 11) {
                    $student->eliminatory = true;
                } else {
                    $student->validated = false;
                }
            }
        }

        return view('students', compact('students', 'fieldOfStudy'));
    }
    public function index9()
    {
        $fieldOfStudies = FieldOfStudy::all();
        $levels = Level::all();

        return view('results_index', compact('fieldOfStudies', 'levels'));
    }

    
    

    private function getStatus($score, $fieldOfStudyName)
    {
        if ($fieldOfStudyName !== 'Cycle Preparatoire') {
            // Si la filière n'est pas "Cycle Préparatoire"
            if ($score >= 12 && $score <= 20) {
                return 'Validé';
            } elseif ($score >= 8 && $score < 12) {
                return 'Non valide ';
            } else {
                return 'Note Eliminatoire';
            }
        } else {
            // Si la filière est "Cycle Préparatoire"
            if ($score >= 10 && $score <= 20) {
                return 'Validé';
            } elseif ($score >= 7 && $score < 10) {
                return 'Non valide';
            } else {
                return 'Note Eliminatoire';
            }
        }
    }
    


    public function getModulesByLevel(Request $request, $levelId)
    {
        // Récupérer les modules en fonction du niveau sélectionné
        $modules = Module::where('level_id', $levelId)->get();

        return response()->json(['modules' => $modules]);
    }
private function getMinScoreForFieldOfStudy($fieldOfStudyId)
    {
        // Exemple de logique pour retourner le score minimum en fonction de l'ID de la filière
        return $fieldOfStudyId === 'Cycle Préparatoire' ? 10 : 12;
    }
    public function selectModule(Request $request)
    {
        $fieldOfStudy = $request->input('field_of_study_name');
        $levelId = $request->input('level_id');
    
        // Récupérer les modules pour le niveau sélectionné
        $modules = Module::where('niveau_id', $levelId)->get();
    
        return view('select-module', compact('fieldOfStudy', 'levelId', 'modules'));
    }
    public function show9(Request $request)
    {
        $fieldOfStudyName = $request->input('field_of_study_name');
        $levelId = $request->input('level_id');
        $moduleId = $request->input('module_id');
    
        // Récupérer l'ID de la filière en fonction du nom
        $fieldOfStudy = FieldOfStudy::where('name', $fieldOfStudyName)->first();
    
        if (!$fieldOfStudy) {
            // Gérer le cas où la filière n'est pas trouvée
            abort(404, "Filière non trouvée pour le nom: $fieldOfStudyName");
        }
    
        $fieldOfStudyId = $fieldOfStudy->id;
    
        // Initialiser un tableau pour stocker les étudiants
        $students = [];
    
        // Récupérer les étudiants ayant validé le module depuis la table Grades
        $validatedStudents = Grade::where('field_of_study_id', $fieldOfStudyId)
                                  ->where('level_id', $levelId)
                                  ->where('module_id', $moduleId)
                                  ->where('score', '>=', $this->getMinScoreForFieldOfStudy($fieldOfStudyId))
                                  ->get();
    
        // Récupérer les étudiants depuis la table RattrapageStudents
        $rattrapageStudents = RattrapageStudent::where('field_of_study_id', $fieldOfStudyId)
                                               ->where('module_id', $moduleId)
                                               ->get();
    
        // Assembler les étudiants validész
        foreach ($validatedStudents as $grade) {
            $students[] = [
                'name' => $grade->student->name, // Assurez-vous que la relation student est correctement définie dans le modèle Grade
                'score' => $grade->score,
                'status' => $this->getStatus($grade->score, $fieldOfStudyName),
            ];
        }
    
        // Assembler les étudiants en rattrapage
        foreach ($rattrapageStudents as $rattrapage) {
            $students[] = [
                'name' => $rattrapage->student->name, // Assurez-vous que la relation student est correctement définie dans le modèle RattrapageStudent
                'score' => $rattrapage->score,
                'status' => $this->getStatus($rattrapage->score, $fieldOfStudyName),
            ];
        }
    
        // Retourner la vue avec les données
        return view('results_show', compact('students'));
    }
}