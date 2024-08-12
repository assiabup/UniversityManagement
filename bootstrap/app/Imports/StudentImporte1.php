<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Student;
use App\Models\FieldOfStudy;
use App\Models\Level;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Storage;

class StudentImporte1 implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Générer un mot de passe aléatoire non haché
        $plainPassword = Str::random(10);

        // Création d'un nouvel utilisateur avec le mot de passe haché
        $user = User::create([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($plainPassword),
            'role' => 2,
            // Utiliser le mot de passe haché
        ]);

        // Envoi de l'email de bienvenue avec le mot de passe non haché
        Mail::to($row['email'])->send(new WelcomeEmail($row['name'], $row['email'], $plainPassword));

        // Recherche de la filière existante en fonction du nom spécifié
        $fieldOfStudyName = $row['field_of_study'];
        $fieldOfStudy = FieldOfStudy::where('name', $fieldOfStudyName)->first();

        // Vérifier si la filière existe
        if (!$fieldOfStudy) {
            throw new \Exception('La filière spécifiée (' . $fieldOfStudyName . ') n\'existe pas.');
        }

        // Recherche du niveau de filière existant en fonction du nom spécifié
        $levelName = $row['level'];
        $level = Level::where('name', $levelName)->where('field_of_study_id', $fieldOfStudy->id)->first();

        // Vérifier si le niveau de filière existe
        if (!$level) {
            throw new \Exception('Le niveau de filière spécifié (' . $levelName . ') n\'existe pas pour la filière ' . $fieldOfStudyName);
        }

        // Création d'un nouvel étudiant associé à cet utilisateur, à la filière et au niveau de filière existants
        $student = new Student([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($plainPassword), // Utiliser le mot de passe haché
            'cne' => $row['cne'],
            'year_of_study' => $row['year_of_study'],
            'image' => $row['image'],
            'field_of_study_id' => $fieldOfStudy->id,
            'level_id' => $level->id,
            'field_of_study'=>$fieldOfStudyName ,
        ]);

        // Association de l'utilisateur à l'étudiant et enregistrement de l'étudiant
        $student->user()->associate($user);
        $student->save();

        return $student;
    }
}
