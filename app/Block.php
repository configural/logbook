<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    // name - название
    // discipline_id - дисциплина, к которой привязан блок
    //*_hours - часов: лекции, практика, самостоятельная работа
    protected $fillable = ['name', 'discipline_id', 'active', 'l_hours', 'p_hours', 's_hours', 'block_type'];
    
    public function discipline() {
        return $this->hasOne('\App\Discipline', 'id', 'discipline_id');
    }
    
    public function type() {
        return $this->hasOne('\App\BlockType', 'id', 'type_id');
    }
    
    public function in_timetable() {
        return $this->hasMany('\App\Timetable', 'block_id', 'id');
    
    }
 
}
