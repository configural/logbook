<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    //
    protected $table = "journal";
    
    protected $fillable = ['timetable_id', 'teacher_id', 'l_hours', 'p_hours', 'attendance'];
    
    public function timetable() {
        return $this->hasOne('\App\Timetable', 'id', 'timetable_id');
    }
}
