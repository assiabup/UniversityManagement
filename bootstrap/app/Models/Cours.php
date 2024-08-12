<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'module_id',
        'archived',
        'type',
        'field_of_study_id',
        'level_id',

    ];


    public function archive()
    {
        $this->archived = true;
        $this->save();
    }
    public function unarchive()
    {
        $this->archived = false;
        $this->save();
    }
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
    public function isArchivedForLevelAndFieldOfStudy($levelId, $fieldOfStudyId)
    {
        return $this->archived &&
               $this->level_id == $levelId &&
               $this->field_of_study_id == $fieldOfStudyId;
    }
  
    
   
}
