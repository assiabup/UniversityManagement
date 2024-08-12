<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\models\Level;
use App\Models\Module;
use App\Models\Absence;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Homework;
use Illuminate\Support\Str;
use App\Mail\TeacherCreated;
use App\models\FieldOfStudy;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;



class TeacherController extends Controller{
    public function index()
    {
        $teachers = Teacher::all();
        return view('teachers.index', compact('teachers'));
    }


    // Afficher le formulaire de création d'un enseignant
 //   public function create()
   // {
  ///      $fieldOfStudies = FieldOfStudy::all();
   //     $levels = Level::all();
   // 
    //    return view('teachers_create', compact('fieldOfStudies', 'levels'));
   // }
//  public function store(Request $request)
//{
    // Validation des données du formulaire
  //  $validator = Validator::make($request->all(), [
    //    'name' => 'required|string|max:255',
    //    'email' => 'required|email|unique:teachers,email|unique:users,email',
    ///    'department' => 'required|string|max:255',
    //    'field_of_studies' => 'required|array',
    //    'levels' => 'required|array',
     //   'modules' => 'required|array',
      //  'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
      //  'modules.*' => function ($attribute, $value, $fail) {
      ///      // Vérifier si le module est déjà associé à un autre professeur
       //     $isModuleUsed = Teacher::whereHas('modules', function ($query) use ($value) {
       ////         $query->where('modules.id', $value); 
       //     })->exists();

        ///    if ($isModuleUsed) {
        ///        $fail("Le module sélectionné est déjà associé à un autre professeur.");
       //     }
       /// },
 //   ]);

    // Vérifier si la validation a échoué
  //  if ($validator->fails()) {
  //      return redirect()->route('teachers.createTeacherForm')
  //          ->withErrors($validator)
  //          ->withInput();
  ///  }

    // Création de l'utilisateur
    //$randomPassword = Str::random(10);
   // $user = User::create([
  // //     'name' => $request->input('name'),
   ///     'email' => $request->input('email'),
  //      'password' => Hash::make($randomPassword),
    //    'role' => 2, // Rôle d'enseignant
    //]);

    // Création du professeur dans la base de données
   // $teacher = Teacher::create([
     //   'name' => $request->input('name'),
      //  'email' => $request->input('email'),
      //  'department' => $request->input('department'),
     //   'user_id' => $user->id, // Associer l'ID de l'utilisateur au professeur
      //  'password' => Hash::make($randomPassword),
      //  'field_of_studies' => json_encode($request->input('field_of_studies')),
      //  'levels' => json_encode($request->input('levels')),
     //   'modules' => json_encode($request->input('modules')),
   // ]);

    // Gestion de l'image
 //   if ($request->hasFile('image')) {
  //      $imagePath = $request->file('image')->store('teacher_images', 'public');
  //      $teacher->profile_photo = $imagePath;
 //       $teacher->save();
  //  }

  //  // Envoi de l'email avec le mot de passe aléatoire
  //  try {
  //      // Envoyer l'email avec les détails du professeur
  //      Mail::to($teacher->email)->send(new TeacherCreated($teacher, $randomPassword));
  //  } catch (\Exception $e) {
        // Gérer l'erreur d'envoi de l'email ici
   // }

 //   return redirect()->route('contenue')->with('success', 'Enseignant créé avec succès');
//}

   
   // Méthode pour s'assurer que la donnée est un tableau
   private function ensureArray($value)
   {
       if (is_array($value)) {
           return $value;
       } else {
           return [$value];
       }
   }
   
   
    // Mettre à jour les informations d'un enseignant dans la base de données
    public function update(Request $request, Teacher $teacher)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'department' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            $image = $request->file('profile_photo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/profile-photos', $imageName);
            $validatedData['profile_photo'] = $imageName;
        }

        $teacher->update($validatedData);

        return redirect()->route('teachers.index')->with('success', 'Enseignant modifié avec succès.');
    }

    // Supprimer un enseignant de la base de données
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
     return redirect()->route('teachers.index')->with('success', 'Enseignant supprimé avec succès.');
   }
    public function selectModules(Request $request)
{
  //   Validation des données du formulaire
   $validator = Validator::make($request->all(), [
        'field_of_studies' => 'required|array',
        'levels' => 'required|array',
  ]);
/////
    // Vérifier si la validation a échoué
  if ($validator->fails()) {
       return redirect()->route('teachers.create')
       ->withErrors($validator)
          ->withInput();
   }

    // Récupérer les IDs des filières et niveaux sélectionnés
   $fieldOfStudies = $request->input('field_of_studies');
   $levels = $request->input('levels');
//
     //Récupérer les modules associés aux filières et niveaux sélectionnés
  $modules = Module::whereIn('field_of_study_id', $fieldOfStudies)
       ->whereIn('niveau_id', $levels)
       ->get();

  //  Afficher une vue pour sélectionner les modules
 return view('select_modules', compact('modules'));
}
public function showSelectFiliereNiveau1()
{
    $fieldOfStudies = FieldOfStudy::all();
    $levels = Level::all();

    return view('afficher_prof', compact('fieldOfStudies', 'levels'));
}

public function showProfessors(Request $request)
{
    $fieldOfStudyId = $request->input('field_of_study');
    $levelId = $request->input('level');

    $professors = Teacher::whereHas('fieldOfStudies', function ($query) use ($fieldOfStudyId) {
            $query->where('field_of_studies.id', $fieldOfStudyId); // Spécifier la table 'field_of_studies' pour éviter l'ambiguïté
        })
        ->whereHas('levels', function ($query) use ($levelId) {
            $query->where('levels.id', $levelId); // Spécifier la table 'levels' pour éviter l'ambiguïté
        })
        ->with('modules') // Chargement des modules associés à chaque professeur
        ->get();

    return view('professorsWithModules', compact('professors'));
}
public function selectModulesForm()
{
    $fieldsOfStudy = FieldOfStudy::all();
    $levels = Level::all();

    return view('modules_select5', compact('fieldsOfStudy', 'levels'));
}

// Afficher les modules en fonction de la filière et du niveau sélectionnés
public function showModules(Request $request)
{
    $validatedData = $request->validate([
        'field_of_study_id' => 'required|exists:field_of_studies,id',
        'level_id' => 'required|exists:levels,id',
    ]);

    $fieldOfStudy = FieldOfStudy::findOrFail($validatedData['field_of_study_id']);
    $level = Level::findOrFail($validatedData['level_id']);

    $modules = $fieldOfStudy->modules()->where('niveau_id', $level->id)->get();

    return view('modules_index5', compact('modules', 'fieldOfStudy', 'level'));
}
public function index_teacher()
{
    $teachers = Teacher::all();
    return view('all_teachers', compact('teachers'));
}

public function destroy_teacher(Teacher $teacher)
{
    $teacher->delete();
    return redirect()->route('teachers.index')->with('success', 'Professeur supprimé avec succès.');
}
public function showTeachingModules()
{
    // Vérifier le rôle de l'utilisateur
    if (Auth::user()->role !== 2) {
        $message = 'Vous n\'avez pas les autorisations nécessaires pour cette page.';
        return view('error', compact('message'));
    }

    // Récupérer l'enseignant associé à l'utilisateur authentifié
    $teacher = Auth::user()->teacher;

    // Vérifier si l'enseignant existe
    if (!$teacher) {
        $message = 'Aucun enseignant associé à cet utilisateur.';
        return view('error', compact('message'));
    }

    // Récupérer les modules que le professeur enseigne
    $modules = $teacher->modules;

    return view('professor_modules', compact('modules'));
}

public function showSubmissions($moduleId)
{
    // Récupérer les devoirs soumis pour ce module
    $submissions = Homework::where('module_id', $moduleId)->get();

    return view('professor_submissions', ['submissions' => $submissions]);
}

public function downloadHomework($homeworkId)
{
    // Récupérer le chemin du fichier PDF du devoir
    $homework = Homework::find($homeworkId);

    // Télécharger le fichier
    return response()->download(storage_path("app/public/{$homework->pdf_path}"));
}
////3ad zadtha///////////////////////
public function getModulesByFieldAndLevel(Request $request)
{
    $fieldOfStudies = $request->input('field_of_studies');
    $levels = $request->input('levels');

    $modules = Module::whereIn('field_of_study_id', $fieldOfStudies)
                      ->whereIn('level_id', $levels)
                      ->get();

    return response()->json($modules);
    // app/Http/Controllers/TeacherController.php
    ////////////////////////////////////////////////////////////////////////
}
public function selectFieldOfStudies()
{
    $fieldOfStudies = FieldOfStudy::all();
    return view('selectFieldOfStudies', compact('fieldOfStudies'));
}

public function selectLevels(Request $request)
{
    // Récupérer les filières sélectionnées depuis la requête
    $fieldOfStudies = $request->input('field_of_studies', []);
    
    // S'assurer que $fieldOfStudies est un tableau
    $fieldOfStudies = is_array($fieldOfStudies) ? $fieldOfStudies : [$fieldOfStudies];
    
    // Récupérer les niveaux associés aux filières sélectionnées
    $levels = Level::whereIn('field_of_study_id', $fieldOfStudies)->get();
    
    return view('selectLevels', compact('levels', 'fieldOfStudies'));
}

public function selectModules1(Request $request)
{
    // Récupérer les filières et niveaux sélectionnés depuis la requête
    $fieldOfStudies = $request->input('field_of_studies', []);
    $levels = $request->input('levels', []);

    // S'assurer que $fieldOfStudies et $levels sont des tableaux
    $fieldOfStudies = is_array($fieldOfStudies) ? $fieldOfStudies : [$fieldOfStudies];
    $levels = is_array($levels) ? $levels : [$levels];

    // Récupérer les modules associés aux filières et niveaux sélectionnés
    $modules = Module::whereIn('field_of_study_id', $fieldOfStudies)
                     ->whereIn('niveau_id', $levels)
                     ->get();

    return view('selectModules', compact('modules', 'fieldOfStudies', 'levels'));
}
public function createTeacherForm(Request $request)
{
    // Récupérer les filières, niveaux et modules sélectionnés depuis la requête
    $fieldOfStudies = $request->input('field_of_studies', []);
    $levels = $request->input('levels', []);
    $modules = $request->input('modules', []);

    // S'assurer que $fieldOfStudies, $levels et $modules sont des tableaux
    $fieldOfStudies = is_array($fieldOfStudies) ? $fieldOfStudies : [$fieldOfStudies];
    $levels = is_array($levels) ? $levels : [$levels];
    $modules = is_array($modules) ? $modules : [$modules];

    // Passer les données à la vue
    return view('createTeacherForm', compact('fieldOfStudies', 'levels', 'modules'));
}
//////////////////////////////////////////////////////////////////////////////////////////////////////
public function create()
{
    $fieldOfStudies = FieldOfStudy::all();
    return view('teacher_create', compact('fieldOfStudies'));
}

public function getLevels(Request $request)
{
    $fieldOfStudyIds = $request->input('field_of_study_ids');
    $levels = Level::whereIn('field_of_study_id', $fieldOfStudyIds)->get();

    return response()->json(['levels' => $levels]);
}

public function getModules(Request $request)
{
    $levelIds = $request->input('level_ids');
    $modules = Module::whereIn('niveau_id', $levelIds)->get();

    return response()->json(['modules' => $modules]);
}

public function store(Request $request)
{
    // Validation des données du formulaire
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:teachers,email|unique:users,email',
        'department' => 'required|string|max:255',
        'field_of_studies' => 'required|array',
        'levels' => 'required|array',
        'modules' => 'required|array',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Validation personnalisée pour les modules
    $validator->after(function ($validator) use ($request) {
        foreach ($request->input('modules') as $moduleId) {
            $isModuleUsed = Teacher::whereHas('modules', function ($query) use ($moduleId) {
                $query->where('modules.id', $moduleId);
            })->exists();

            if ($isModuleUsed) {
                $validator->errors()->add('modules', "Le module sélectionné est déjà associé à un autre professeur.");
            }
        }
    });

    if ($validator->fails()) {
        return redirect()->route('teachers.createTeacherForm')
            ->withErrors($validator)
            ->withInput();
    }

    $randomPassword = Str::random(10);
    $user = User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => Hash::make($randomPassword),
        'role' => 2,
    ]);

    $teacher = Teacher::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'department' => $request->input('department'),
        'user_id' => $user->id,
        'password' => Hash::make($randomPassword),
    ]);

    $teacher->fieldOfStudies()->attach($request->input('field_of_studies'));
    $teacher->levels()->attach($request->input('levels'));
    $teacher->modules()->attach($request->input('modules'));

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('teacher_images', 'public');
        $teacher->profile_photo = $imagePath;
        $teacher->save();
    }

    try {
        Mail::to($teacher->email)->send(new TeacherCreated($teacher, $randomPassword));
    } catch (\Exception $e) {
        // Gérer l'erreur d'envoi de l'email ici
    }

    return redirect()->route('salam')->with('success', 'Enseignant créé avec succès');
}
public function showStudentsByTeacherAndLevel(Request $request)
{
    // Récupérer l'identifiant du professeur depuis la session ou tout autre moyen
    $teacherId = Auth::user()->teacher->id;
    
    // Récupérer les filières enseignées par le professeur
    $fieldOfStudies = Teacher::findOrFail($teacherId)->fieldOfStudies()->pluck('id');

    // Récupérer les niveaux enseignés par le professeur dans ces filières
    $levels = Teacher::findOrFail($teacherId)->levels()->pluck('levels.id');

    // Filtrez les choix de filières et de niveaux dans la requête
    $selectedFieldOfStudy = $request->input('field_of_study');
    $selectedLevel = $request->input('level');

    

    return view('students_by_teacher_and_level', compact('fieldOfStudies', 'levels'));
}
public function showStudentsByFieldAndLevel(Request $request)
{
    // Récupérer les données du formulaire
    $fieldOfStudyId = $request->input('field_of_study');
    $levelId = $request->input('level');

    // Récupérer les étudiants correspondants à la filière et au niveau sélectionnés
    // Vous devrez écrire la logique pour récupérer les étudiants en fonction des filières et des niveaux sélectionnés
    // Je vais supposer que vous avez un modèle Student pour cela
    $students = Student::where('field_of_study_id', $fieldOfStudyId)
                       ->where('level_id', $levelId)
                       ->get();

    return view('students_by_field_and_level', compact('students'));
}

public function showStudentsByTeacherAndLevel1(Request $request)
{
    // Récupérer l'identifiant du professeur depuis la session ou tout autre moyen
    $teacherId = Auth::user()->teacher->id;
    
    // Récupérer les filières enseignées par le professeur
    $fieldOfStudies = Teacher::findOrFail($teacherId)->fieldOfStudies;

    // Récupérer les niveaux enseignés par le professeur dans ces filières
    $levels = Teacher::findOrFail($teacherId)->levels()->pluck('levels.id');

    // Filtrez les choix de filières et de niveaux dans la requête
    $selectedFieldOfStudy = $request->input('field_of_study');
    $selectedLevel = $request->input('level');

    

    // Passer les données à la vue
    return view('etudiant_absence', compact('fieldOfStudies', 'levels'));
}
public function showForm(Request $request)
{
     // Récupérer l'identifiant du professeur depuis la session ou tout autre moyen
     $teacherId = Auth::user()->teacher->id;

     // Récupérer les filières enseignées par le professeur
     $fieldOfStudies = Teacher::findOrFail($teacherId)->fieldOfStudies()->pluck('id');
 
     // Récupérer les niveaux enseignés par le professeur dans ces filières
     
     $levels = Teacher::findOrFail($teacherId)
     ->levels()
     ->select('levels.id') // Spécifier la table pour éviter l'ambiguité
     ->pluck('levels.id');
     // Filtrez les choix de filières et de niveaux dans la requête
     $selectedFieldOfStudy = $request->input('field_of_study');
     $selectedLevel = $request->input('level');
 
     // Récupérer les modules associés au professeur et au niveau sélectionnés
     $modules = Module::whereHas('teachers', function($query) use ($teacherId) {
         $query->where('teacher_id', $teacherId);
     })->where('field_of_study_id', $selectedFieldOfStudy)
       ->whereIn('niveau_id', $levels)
       ->get();
 
     // Retourner la vue avec les données des modules
     return view('absence_form', compact('modules'));
 }
    
    
    public function saveAbsences(Request $request)
    {
        $request->validate([
            'absence_date' => 'required|date',
            'absent_students' => 'required|array',
        ]);
    
        $moduleId = $request->input('module');
        $absenceDate = $request->input('absence_date');
        $absentStudents = $request->input('absent_students');
    
        // Enregistrement des absences dans la base de données
        foreach ($absentStudents as $studentId) {
            Absence::create([
                'module_id' => $moduleId,
                'student_id' => $studentId,
                'absence_date' => $absenceDate,
            ]);
        }
    
        return redirect()->back()->with('success', 'Absences enregistrées avec succès.');
    }
    

    
    public function showStudentsWithAbsences()
{
    $studentsWithAbsences = DB::table('students')
    ->select('students.id', 'students.name', 'students.email', 'students.cne', DB::raw('COUNT(absences.id) as total_absences'))
    ->leftJoin('absences', 'students.id', '=', 'absences.student_id')
    ->groupBy('students.id', 'students.name', 'students.email', 'students.cne')
    ->get();

return view('students_with_absences', compact('studentsWithAbsences'));
}
}