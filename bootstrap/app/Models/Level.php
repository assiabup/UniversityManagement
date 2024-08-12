<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    protected $fillable = ['name']; // Spécifiez les colonnes fillable

    public function fieldOfStudy()
    {
        return $this->belongsTo(FieldOfStudy::class, 'field_of_study_id');
    }
    public function modules()
    {
        return $this->hasMany(Module::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
    public function teachers()
{
    return $this->belongsToMany(Teacher::class);
}
public function annonces()
    {
        return $this->belongsToMany(Annonce::class, 'annonce_level', 'level_id', 'annonce_id');
    }


}
