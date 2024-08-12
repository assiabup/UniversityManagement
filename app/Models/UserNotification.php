<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserNotification extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'message',
        'read',
    ];
    protected $table = 'notifications';
   
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'notification_user', 'notification_id', 'user_id');
    }
    
}
