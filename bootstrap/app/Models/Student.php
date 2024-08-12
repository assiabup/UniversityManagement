<?php

namespace App\Models;

use App\Models\Level; 
use App\Models\Absence;
use App\Models\UserNotification;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cne',
        'field_of_study',
        'year_of_study',
        'image',
        'user_id',
        'field_of_study_id',
        'level_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

  protected static function boot()
  {
       parent::boot();


       static::saving(function ($student) {
         // Valider le format du CNE
     if (!preg_match('/^N\d{9}$/', $student->cne)) {
         throw new \Exception('Formatmreyy CNE invalide.');
        }
        });
   }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

  
    public function professors()
    {
        return $this->belongsToMany(Teacher::class);
    }
 
public function fieldOfStudy()
{
    return $this->belongsTo(FieldOfStudy::class);
}
public function grades()
    {
        return $this->hasMany(Grade::class);
    }
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function notifications(): BelongsToMany
    {

        return $this->belongsToMany(UserNotification::class,'student_id', 'notification_id');
    }
    

    public function absences()
    {
        return $this->hasMany(Absence::class, 'student_id');
    }
}