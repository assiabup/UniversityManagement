<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RattrapageStudent extends Model
{
    use HasFactory;
    protected $table = 'rattrapage_students'; // Nom de la table associée au modèle

    protected $fillable = [
        'student_id',
        'module_id',
        'field_of_study_id',
        'score',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function fieldOfStudy()
    {
        return $this->belongsTo(FieldOfStudy::class, 'field_of_study_id');
    }
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'student_id', 'student_id')
            ->where('module_id', $this->module_id)
            ->where('field_of_study_id', $this->field_of_study_id);
    }
}
