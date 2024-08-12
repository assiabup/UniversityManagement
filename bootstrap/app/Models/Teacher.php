<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\Level; 


class Teacher extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'teachers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'department',
        'profile_photo',
        'user_id',
        // Ajoutez d'autres attributs ici
    ];
 
    /**
     * Set the user's password.
     *
     * @param  string  $password
     * @return void
     * 
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
    public function fieldOfStudies()
{
    return $this->belongsToMany(FieldOfStudy::class);
}



public function user()
{
    return $this->hasOne(User::class, 'id', 'user_id');
}
    public function taughtLevels()
    {
        return $this->belongsToMany(Level::class, 'level_teacher', 'teacher_id', 'level_id');
    }
   
    public function levels()
    {
        return $this->belongsToMany(Level::class, 'level_teacher', 'teacher_id', 'level_id');
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'module_teacher', 'teacher_id', 'module_id');
    }

    public function fieldsOfStudy()
    {
        return $this->belongsToMany(FieldOfStudy::class, 'field_of_study_teacher', 'teacher_id', 'field_of_study_id');
    }
    
   

}