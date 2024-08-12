<?php

namespace App\Imports;

use App\Models\RattrapageStudent;
use App\Models\Grade;
use App\Models\Student;
use App\Models\FieldOfStudy;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Module;
use Exception;

class importe_grades_ratt implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Recherche de l'étudiant par son CNE
        $student = Student::where('cne', $row['cne'])->first();

        if (!$student) {
            throw new Exception("Étudiant avec CNE {$row['cne']} introuvable.");
        }

        // Recherche du module par son nom
        $module = Module::where('name', $row['module_name'])->first();

        if (!$module) {
            throw new Exception("Module avec le nom {$row['module_name']} introuvable.");
        }

        // Recherche de la filière par son nom (field_of_study_name)
        $fieldOfStudy = FieldOfStudy::where('name', $row['field_of_study_name'])->first();

        if (!$fieldOfStudy) {
            throw new Exception("Filière avec le nom {$row['field_of_study_name']} introuvable.");
        }

        // Vérifier si l'étudiant a déjà validé le module
        $grade = Grade::where('student_id', $student->id)
                      ->where('module_id', $module->id)
                      ->where('field_of_study_id', $fieldOfStudy->id)
                      ->first();

        if (!$grade) {
            // Aucune note initiale trouvée, lancer une exception
            throw new Exception("Aucune note initiale trouvée pour l'étudiant avec CNE {$row['cne']}, le module {$row['module_name']} et la filière {$row['field_of_study_name']}.");
        }

        // Récupérer la note initiale depuis la table grades
        $initialScore = $grade->score;

        // Déterminer la nouvelle note à enregistrer en fonction des conditions de la filière
        $newScore = $row['score'];

        if ($newScore > $initialScore) {
            // La nouvelle note est supérieure à la note initiale, limiter la note aux valeurs autorisées
            $maxScore = $fieldOfStudy->name === 'Cycle Préparatoire' ? 10 : 12;
            $finalScore = min($newScore, $maxScore);

            // Enregistrer la nouvelle note dans la table RattrapageStudent
            RattrapageStudent::create([
                'student_id' => $student->id,
                'module_id' => $module->id,
                'field_of_study_id' => $fieldOfStudy->id,
                'score' => $finalScore,
            ]);
        } else {
            // La nouvelle note n'est pas supérieure à la note initiale
            // Enregistrer la note initiale dans la table RattrapageStudent
            RattrapageStudent::create([
                'student_id' => $student->id,
                'module_id' => $module->id,
                'field_of_study_id' => $fieldOfStudy->id,
                'score' => $initialScore,
            ]);
        }

        return $student; // Retourne l'objet Student
    }
}
