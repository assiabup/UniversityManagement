<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        // Vérifie si l'utilisateur est authentifié
        if (Auth::check()) {
            $userId = auth()->id(); // Récupérer l'ID de l'utilisateur authentifié
    
            // Récupère les notifications pour l'utilisateur authentifié
            $notifications = UserNotification::whereIn('id', function($query) use ($userId) {
                $query->select('notification_id')
                      ->from('notification_user') // 
                      ->where('user_id', $userId);
            })->get();
    
            // Marque toutes les notifications comme lues
            $notifications->each(function ($notification) {
                if (!$notification->read) {
                    $notification->update(['read' => true]);
                }
            });
    
            // Passe les notifications à la vue
            return view('contenue', compact('notifications'));
        } else {
            // Redirige vers la page de connexion ou affiche un message d'erreur
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour voir vos notifications.');
        }
    }
    
    public function show1()
    {
        if (Auth::check()) {
            $userId = auth()->id(); // Récupérer l'ID de l'utilisateur authentifié
            
            // Pagination pour récupérer les notifications de l'utilisateur
            $notifications = UserNotification::whereIn('id', function($query) use ($userId) {
                $query->select('notification_id')
                      ->from('notification_user') // Remplacez 'notification_user' par le nom réel de votre table pivot
                      ->where('user_id', $userId);
            })->paginate(4);
            
            // Marquez toutes les notifications comme lues (si nécessaire)
           
            $notifications->each(function ($notification) {
                if (!$notification->read) {
                    $notification->update(['read' => true]);
                }
            });
            // Récupérer le nombre total de notifications
            $totalNotifications = $notifications->total();
            
            // Passe les notifications paginées à la vue
            return view('student_notifications', compact('notifications', 'totalNotifications'));
        } else { 
            // Redirige vers la page de connexion ou affiche un message d'erreur
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour voir vos notifications.');
        }
    } 
}
