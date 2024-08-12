<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['name', 'code', 'description', 'field_of_study_id'];

    public function fieldOfStudy()
    {
        return $this->belongsTo(FieldOfStudy::class, 'field_of_study_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }


    public function activeCourses()
    {
        return $this->hasMany(Cours::class)->where('archived', false);
    }

    /**
     * Get all archived courses for this module.
     */
    public function archivedCourses()
    {
        return $this->hasMany(Cours::class)->where('archived', true);
    }
    public function cours()
    {
        return $this->hasMany(Cours::class, 'module_id');
    }
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function teachers()
{
    return $this->belongsToMany(Teacher::class, 'module_teacher');
}

    public function absences()
    {
        return $this->belongsToMany(Absence::class, 'module_absence');
    }
}
