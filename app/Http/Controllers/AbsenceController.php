<?php
namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Module;
use App\Models\Absence;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\FieldOfStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class AbsenceController extends Controller
{
    

    public function create(Request $request)
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
       
 // Récupérer les étudiants associés à la filière et au niveau sélectionnés
 $students = Student::where('field_of_study_id', $selectedFieldOfStudy)
 ->where('level_id', $selectedLevel)
 ->get();
     // Retourner la vue avec les données des modules
     return view('absences_create', compact('modules','students'));
 }

        
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'absence_date' => 'required|date',
            'modules' => 'required|exists:modules,id',
            'modules.*' => 'exists:modules,id',
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
        ]);

        $absence = Absence::create([
            'absence_date' => $data['absence_date'],
            'module_id' => $data['modules']
        ]);

        $absence->modules()->attach($data['modules']);
        $absence->students()->attach($data['students']);

        return redirect()->route('absences.index');
    }

    public function index()
    {
        $absences = DB::table('student_absence')
                    ->join('module_absence', 'student_absence.absence_id', '=', 'module_absence.absence_id')
                    ->join('absences', 'student_absence.absence_id', '=', 'absences.id')
                    ->select('absences.absence_date', 'student_absence.student_id', 'module_absence.module_id', DB::raw('COUNT(*) as total_absences'))
                    ->groupBy('absences.absence_date', 'student_absence.student_id', 'module_absence.module_id')
                    ->get();
    
        return view('contenue', compact('absences'));
    }
  
public function showCriteriaForm(Request $request)
{
    // Récupérer l'identifiant du professeur depuis la session ou tout autre moyen
    $teacherId = Auth::user()->teacher->id;

    // Récupérer les filières, niveaux et modules associés au professeur
    $teacher = Teacher::with(['fieldsOfStudy', 'levels', 'modules'])->findOrFail($teacherId);

    $filieres = $teacher->fieldsOfStudy;
    $niveaux = $teacher->levels;
    $modules = $teacher->modules;

    // Passer les données à la vue
    return view('select_criteria', compact('filieres', 'niveaux', 'modules'));
}

public function getAbsencesList(Request $request)
{
    // Récupérer l'ID du module spécifique depuis la requête
    $moduleId = $request->input('module');
    // Récupérer l'ID de la filière et du niveau sélectionnés depuis la requête
    $fieldOfStudyId = $request->input('field_of_study');
    $levelId = $request->input('level');
 
    // Récupérer tous les étudiants de la filière et du niveau sélectionnés
    $students = DB::table('students')
        ->where('field_of_study_id', $fieldOfStudyId)
        ->where('level_id', $levelId)
        ->get();

    // Pour chaque étudiant, compter le nombre d'absences associé au module spécifique
    foreach ($students as $student) {
        $absencesCount = DB::table('student_absence as sa')
            ->join('absences as a', 'sa.absence_id', '=', 'a.id')
            ->join('module_absence as ma', 'a.id', '=', 'ma.absence_id')
            ->where('sa.student_id', $student->id)
            ->where('ma.module_id', $moduleId)
            ->count();

        // Ajouter le nombre d'absences à l'objet étudiant
        $student->absences_count = $absencesCount;
    }

    // Passer les étudiants et l'ID du module à la vue
    return view('absences_list', compact('students', 'moduleId'));
}

}