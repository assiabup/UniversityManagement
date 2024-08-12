<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grade;
use App\Models\Student;
use App\Models\FieldOfStudy;
use Illuminate\Http\Request;
use App\Imports\GradesImport;
use App\Models\UserNotification;
use App\Models\RattrapageStudent;
use App\Imports\importe_grades_ratt;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class GradesController extends Controller
{
    public function index()
    {
        return view('import_main_scores_form');
    }

    public function store2(Request $request)
    {
        $file = $request->file('file');

        if ($file) {
            try {
                Excel::import(new GradesImport(), $file);
                // Identifiez les étudiants concernés par l'affichage
                $students = User::where('role', 'etudiant')->get();

               

             // Créez et associez une notification pour chaque étudiant concerné
             foreach ($students as $student) {
                 // Créer la notification pour chaque étudiant
                 $message = 'Affichage de note';
                 $notification = UserNotification::create([
                     'message' => $message,
                     'read' => false,
                 ]);
                 // Associez la notification à l'étudiant
                 $student->notifications()->attach($notification->id);
             }

                return back()->with('status', 'Le fichier Excel a été importé avec succès.');
            } catch (\Exception $e) {
                Session::flash('error', 'Une erreur s\'est produite lors de l\'importation du fichier Excel : ' . $e->getMessage());
                return back();
            }
        } else {
            Session::flash('error', 'Veuillez sélectionner un fichier Excel.');
            return back();
        }
    }

    public function showFieldOfStudySelection()
    {
        $fieldsOfStudy = FieldOfStudy::all();
        return view('select_field_of_study', compact('fieldsOfStudy'));
    }

    public function showGradesByFieldOfStudy(Request $request)
    {
        $fieldOfStudyId = $request->input('field_of_study_id');
        $fieldOfStudy = FieldOfStudy::findOrFail($fieldOfStudyId);
        $grades = Grade::where('field_of_study_id', $fieldOfStudyId)->get();

        return view('show_grades', compact('fieldOfStudy', 'grades'));
    }

    public function show_ratt1()
    {
        return view("show_ratt");
    }

    public function store3(Request $request)
{
    $file = $request->file('file');

    if ($file) {
        try {
            Excel::import(new importe_grades_ratt(), $file);
             // Identifiez les étudiants concernés par l'affichage
             $students = User::where('role', 'etudiant')->get();

             // Créez et associez une notification pour chaque étudiant concerné
             foreach ($students as $student) {
                 // Créer la notification pour chaque étudiant
                 $message = 'Affichage de note';
                 $notification = UserNotification::create([
                     'message' => $message,
                     'read' => false,
                 ]);
                 // Associez la notification à l'étudiant
                 $student->notifications()->attach($notification->id);
             }
         
            return back()->with('status', 'Le fichier Excel a été importé avec succès.');
        } catch (\Exception $e) {
            Session::flash('error', 'Une erreur s\'est produite lors de l\'importation du fichier Excel : ' . $e->getMessage());
            return back();
        }
    } else {
        Session::flash('error', 'Veuillez sélectionner un fichier Excel.');
        return back();
    }
}


    // Ajouter la méthode pour afficher les notes de l'étudiant connecté
    public function showStudentGrades()
    {
        $student = Auth::user()->student; // Récupérer l'étudiant connecté
        if (!$student) {
            return redirect()->back()->with('error', 'Étudiant non trouvé.');
        }

        $grades = Grade::where('student_id', $student->id)->get(); // Récupérer les notes de l'étudiant
        return view('show_student_grades', compact('grades'));
    }
  
        public function showDeliberation()
        {
            $student = Auth::user()->student;
            $fieldOfStudy=$student->field_of_study;
            
            // Récupérer les notes normales
            
            $grades = Grade::where('student_id', $student->id)->get();
            
            // Récupérer les notes de rattrapage
            $rattrapages = RattrapageStudent::where('student_id', $student->id)->get();
    
            // Calculer les notes finales
            $finalGrades = [];
            foreach ($grades as $grade) {
                $rattrapage = $rattrapages->where('module_id', $grade->module_id)->first();
                $finalScore = $grade->score;
    
               
                
    
                $finalGrades[] = [
                    'module' => $grade->module->name,
                    'score_normale' => $grade->score,
                    'score_final' => $rattrapage ? $rattrapage->score : '-',
                    
                ];
            }
    
            return view('deliberation', compact('finalGrades','fieldOfStudy'));
        }
    }
       

