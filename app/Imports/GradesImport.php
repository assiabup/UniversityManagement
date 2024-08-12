<?php

namespace App\Imports;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Module;
use App\Models\FieldOfStudy;
use App\Models\UserNotification;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GradesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Recherche de l'étudiant par son CNE
        $student = Student::where('cne', $row['cne'])->first();
        if (!$student) {
            throw new \Exception("Étudiant avec CNE {$row['cne']} introuvable.");
        }

        // Recherche du module par son nom
        $module = Module::where('name', $row['module_name'])->first();
        if (!$module) {
            throw new \Exception("Module avec le nom {$row['module_name']} introuvable pour l'étudiant CNE {$row['cne']}.");
        }

        // Recherche de la filière par son nom
        $fieldOfStudy = FieldOfStudy::where('name', $row['field_of_study_name'])->first();
        if (!$fieldOfStudy) {
            throw new \Exception("Filière avec le nom {$row['field_of_study_name']} introuvable pour l'étudiant CNE {$row['cne']}.");
        }

        // Déterminer la note minimale de réussite en fonction de la filière
        $passingScore = $fieldOfStudy->name === 'Cycle Préparatoire' ? 10 : 12;

        // Vérifier si la note de l'étudiant est supérieure ou égale à la note de passage requise
        $isPassed = $row['score'] >= $passingScore;

        // Vérifier s'il existe déjà une entrée pour cette combinaison étudiant, module, filière
        $existingGrade = Grade::where('student_id', $student->id)
            ->where('module_id', $module->id)
            ->where('field_of_study_id', $fieldOfStudy->id)
            ->first();

        if ($existingGrade) {
            throw new \Exception("Une entrée similaire pour l'étudiant avec CNE {$row['cne']} et le module {$row['module_name']} existe déjà.");
        }

        // Enregistrement de la note dans la table Grades
        $grade = new Grade([
            'student_id' => $student->id,
            'module_id' => $module->id,
            'score' => $row['score'],
            'field_of_study_id' => $fieldOfStudy->id,
            'is_pass' => $isPassed,
            'level_id' => $student->level->id, // Récupérer le level_id de l'étudiant
        ]);
        $grade->save();

        

        return $grade;
    }




public function show_ratt(){
    return view("forme_ratt");
}

}