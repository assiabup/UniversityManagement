<?php

namespace App\Http\Controllers;
use App\Models\Level; 


// Importer l modèle Level
use Illuminate\Http\Request;

class SpaceController extends Controller
{
    public function espaces()
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();

        // Vérifier si l'utilisateur est un professeur
        if ($user->role === 2 && $user->teacher) {
            // Récupérer les niveaux enseignés par ce professeur
            $teacher = $user->teacher;
            $taughtLevels = $teacher->levels()->get();

            // Passer les niveaux enseignés à la vue
            return view('professor_space', compact('taughtLevels'));
        }

        // Rediriger en cas d'utilisateur non autorisé ou non associé à un profil de professeur
        return redirect()->route('salam')->with('error', 'Accès non autorisé.');
    }

    public function toggleSpace($level_id, $action)
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();

        // Vérifier si l'utilisateur est un professeur
        if ($user->role === 2 && $user->teacher) {
            // Récupérer le niveau spécifié
            $level = Level::find($level_id);

            // Vérifier si le niveau existe
            if (!$level) {
                return redirect()->back()->with('error', 'Niveau introuvable.');
            }

            // Mettre à jour l'état de l'espace pour le niveau donné
            if ($action === 'open') {
                // Logique pour ouvrir l'espace du niveau (par exemple, mettre à jour une colonne dans la table Level)
                $level->is_open = true;
                $level->save();
                return redirect()->back()->with('success', "Espace ouvert pour le niveau.");
            } elseif ($action === 'close') {
                // Logique pour fermer l'espace du niveau
                $level->is_open = false;
                $level->save();
                return redirect()->back()->with('success', "Espace fermé pour le niveau.");
            }
        }

        // Rediriger en cas d'accès non autorisé ou action invalide
        return redirect()->back()->with('error', "Action non autorisée ou invalide.");
    }

 
}