<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;
    protected $fillable = ['absence_date'];

    protected $dates = ['absence_date'];

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'module_absence');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_absence');
    }
    
    public function prof()
    {
        return $this->belongsTo(Teacher::class);
    }
    
    }

