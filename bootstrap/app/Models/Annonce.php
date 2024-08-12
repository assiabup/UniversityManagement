<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    protected $fillable = ['file_path','user_id'];

    public function filieres()
    {
        return $this->belongsToMany(FieldOfStudy::class, 'annonce_filiere', 'annonce_id', 'filiere_id');
    }

    public function levels()
    {
        return $this->belongsToMany(Level::class, 'annonce_level', 'annonce_id', 'level_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
