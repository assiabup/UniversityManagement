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
    public function students()
    {
        return $this->belongsToMany(Student::class, 'notification_id', 'student_id');
    }
    
}
