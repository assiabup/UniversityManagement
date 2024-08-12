<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Level;
use App\Models\Homework;
use Illuminate\Support\Facades\Auth;

class StudentSpaceController extends Controller
{
    public function index()
    {
        // Récupérer l'étudiant connecté (vous pouvez ajuster cela selon votre système d'authentification)
        $student = Auth::user()->student;
    
        // Vérifier si l'étudiant existe et s'il a un niveau et une filière associés
        if ($student && $student->level_id && $student->field_of_study_id) {
            // Récupérer le niveau associé à l'étudiant
            $level = Level::find($student->level_id);
    
            if ($level) {
                // Passer le niveau à la vue
                return view('student_space_index', [
                    'level' => $level,
                    'isSpaceOpen' => $level->is_open() // Exemple : Appeler une méthode isSpaceOpen() pour déterminer si l'espace est ouvert
                ]);
            }
        }
    
        // Si l'étudiant n'a pas de niveau associé ou si le niveau n'est pas trouvé, rediriger ou afficher un message d'erreur
        return redirect()->route('salam')->with('error', 'Votre niveau ou filière n\'est pas défini.');
    }

       

    public function submitHomework1(Request $request)
    {
        // Récupérer l'étudiant connecté
        $student = auth()->user()->student;

        // Vérifier si l'espace est ouvert pour le niveau de l'étudiant
        if ($student && $student->level_id && $student->field_of_study_id) {
            // Vérifier l'état de l'espace pour ce niveau (par exemple, depuis une table de configuration)
            $isSpaceOpen = true; // Mettez ici la logique pour vérifier si l'espace est ouvert

            if ($isSpaceOpen) {
                // Traitez ici la soumission du devoir
                $homeworkContent = $request->input('homework_content');

                // Enregistrer le devoir dans la base de données ou effectuer toute autre action nécessaire

                return redirect()->back()->with('success', 'Devoir soumis avec succès.');
            } else {
                return redirect()->back()->with('error', 'L\'espace est actuellement fermé pour ce niveau.');
            }
        }

        // Si les informations de l'étudiant ne sont pas valides ou si le niveau n'est pas trouvé
        return redirect()->route('salam')->with('error', 'Impossible de soumettre le devoir.');
    }
}