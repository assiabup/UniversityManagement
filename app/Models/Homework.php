<?php

// app/Models/Homework.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    protected $fillable = ['module_id', 'student_id', 'pdf_path'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}