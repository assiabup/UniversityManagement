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

    public function store(Request $request)
    {
        $request->validate([
            'filiere_ids' => 'required|array',
            'level_ids' => 'required|array',
            'annonce_pdf' => 'required|mimes:pdf|max:2048',
        ]);
    
        $annoncePdf = $request->file('annonce_pdf');
        $filePath = $annoncePdf->store('annonces', 'public');
    
        $annonce = Annonce::create([
            'file_path' => $filePath,
            'user_id' => Auth::id(),
        ]);

        if ($request->filled('filiere_ids') && in_array('all', $request->filiere_ids)) {
            $filiere_ids = FieldOfStudy::pluck('id')->toArray();
        } else {
            $filiere_ids = $request->filiere_ids;
        }
    
        if ($request->filled('level_ids') && in_array('all', $request->level_ids)) {
            $level_ids = Level::pluck('id')->toArray();
        } else {
            $level_ids = $request->level_ids;
        }
    
        $annonce->filieres()->sync($filiere_ids);
        $annonce->levels()->sync($level_ids);
        
        $students = User::whereHas('student', function ($query) use ($level_ids) {
            $query->whereIn('level_id', $level_ids);
        })
        ->where('role', 'etudiant')
        ->get();
    
        foreach ($students as $student) {
            $message = 'Une nouvelle annonce a été publiée.';
            $notification = UserNotification::create([
                'message' => $message,
                'read' => false,
            ]);
        
            $student->notifications()->attach($notification->id);
            Log::info('Notification associée à l\'étudiant: ' . $student->id);
        }
    
        return redirect()->back()->with('success', 'Annonce soumise avec succès.');
    }

    public function index()
    {
        $annonces = Annonce::all();
        return view('announcement', compact('annonces'));
    }

    public function download($id)
    {
        $annonce = Annonce::findOrFail($id);
        $filePath = storage_path('app/public/' . $annonce->file_path);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            abort(404, 'File not found');
        }
    }
    
    public function show3($id)
    {
        $annonce = Annonce::findOrFail($id);
        return view('student_notifications', compact('annonce'));
    }

    public function dashboard()
    {
        $annonces = Annonce::all();
        return view('announcement', ['annonces' => $annonces]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'annonce_pdf' => 'required|mimes:pdf|max:2048',
        ]);

        $annoncePdf = $request->file('annonce_pdf');
        $filePath = $annoncePdf->store('public/annonces');

        $annonce = new Annonce();
        $annonce->file_path = $filePath;
        $annonce->user_id = Auth::id();
        $annonce->save();

        return redirect()->route('annonces.index')->with('success', 'Annonce importée avec succès.');
    }
}
