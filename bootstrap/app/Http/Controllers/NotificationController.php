<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $notifications = UserNotification::where('user_id', Auth::id())
                ->where('read', false)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('contenue', compact('notifications'));
        } else {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour voir vos notifications.');
        }
    }
/*
    public function show1()
    {
        if (Auth::check()) {
            $student = Auth::user();
            
            // Récupère les notifications paginées de l'utilisateur, peu importe leur état de lecture
            $notifications = UserNotification::where('user_id', $student->id)
                ->orderBy('created_at', 'desc')
                ->paginate(8);
                
            // Marque toutes les notifications comme lues
            foreach ($notifications as $notification) {
                $notification->read = true;
                $notification->save();
            }

            // Passe les notifications à la vue
            return view('student_notifications', compact('notifications'));
        } else {
            // Redirige vers la page de connexion ou affiche un message d'erreur
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour voir vos notifications.');
        }
    }
   */
}