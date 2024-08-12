<?php
// app/Models/FieldOfStudy.php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FieldOfStudy extends Model
{
    protected $fillable = [
        'name',
        'disription',
    ];

    // Définition des relations
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function modules()
    {
        return $this->hasMany(Module::class);
    }
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
    public function levels()
    {
        return $this->hasMany(Level::class);
    }
    public function teachers()
{
    return $this->belongsToMany(Teacher::class);
}
public function annonces()
{
    return $this->belongsToMany(Annonce::class, 'annonce_filiere', 'filiere_id', 'annonce_id');
}

}
