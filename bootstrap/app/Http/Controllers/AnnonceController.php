<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Level;
use App\Models\Annonce;
use App\Models\FieldOfStudy;
use Illuminate\Http\Request;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    /**
     * Display the announcement creation form.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->role !== 1) {
            return view('error', ['message' => 'Accès refusé.']);
        }

        $filieres = FieldOfStudy::all();
        $levels = Level::all();
        
        return view('announcements_create', compact('filieres', 'levels'));
    }

    /**
     * Handle the announcement creation form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'filiere_ids' => 'required|array',
            'level_ids' => 'required|array',
            'annonce_pdf' => 'required|mimes:pdf|max:2048', // PDF max size 2MB
        ]);
    
        // Enregistrer le fichier PDF de l'annonce
        $annoncePdf = $request->file('annonce_pdf');
        $filePath = $annoncePdf->store('annonces', 'public');
    
        // Créer une nouvelle annonce
        
        $annonce = Annonce::create([
            'file_path' => $filePath,
            'user_id' => Auth::id(), // Associer l'utilisateur actuel
        ]);
        // Gérer les filières sélectionnées
        if ($request->filled('filiere_ids') && in_array('all', $request->filiere_ids)) {
            // Si "Toutes les filières" est sélectionné, récupérer toutes les filières
            $filiere_ids = FieldOfStudy::pluck('id')->toArray();
        } else {
            // Sinon, utiliser les filières sélectionnées
            $filiere_ids = $request->filiere_ids;
        }
    
        // Gérer les niveaux sélectionnés
        if ($request->filled('level_ids') && in_array('all', $request->level_ids)) {
            // Si "Tous les niveaux" est sélectionné, récupérer tous les niveaux
            $level_ids = Level::pluck('id')->toArray();
        } else {
            // Sinon, utiliser les niveaux sélectionnés
            $level_ids = $request->level_ids;
        }
    
        // Associer les filières et les niveaux à l'annonce
        $annonce->filieres()->sync($filiere_ids);
        $annonce->levels()->sync($level_ids);
        
        // Envoyer des notifications aux étudiants concernés
        $students = User::whereHas('student', function ($query) use ($level_ids) {
            $query->whereIn('level_id', $level_ids);
        })
        ->where('role', 'etudiant')
        ->get();
    /*
        foreach ($students as $student) {
            $message = 'Une nouvelle annonce a été publiée.';
            // Créer une notification pour chaque étudiant
            UserNotification::create([
                'user_id' => $student->id,
                'message' => $message,
                'read' => false,
            ]);
        }
    */
        return redirect()->back()->with('success', 'Annonce soumise avec succès.');
    }
   


    public function index()
    {
        $annonces = Annonce::all();
        return view('announcement', compact('annonces'));
    }
    
  

 

public function download($id)
{
    // Récupérer le chemin du fichier à partir de la base de données ou d'un autre endroit
    $filePath = "annonces/{$id}/monfichier.pdf";

    // Vérifier si le fichier existe
    if (Storage::exists($filePath)) {
        // Télécharger le fichier
        return response()->download(storage_path("app/public/{$filePath}"));
    } else {
        // Retourner une réponse si le fichier n'existe pas
        abort(404, 'Le fichier demandé n\'existe pas.');
    }
}

public function show3($id)
{
    // Récupérer l'annonce en fonction de l'ID
    $annonce = Annonce::findOrFail($id);
  
    // Passer l'annonce à la vue
    return view('student_notifications', compact('annonce'));
}

    public function dashboard()
    {
        // Récupérer les annonces depuis votre base de données
        $annonces = Annonce::all(); // C'est juste un exemple, vous pouvez récupérer les annonces d'une manière spécifique à votre application
    
        // Passer les annonces à la vue dashboard
        return view('announcement', ['annonces' => $annonces]);
    }
    


}    