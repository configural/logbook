<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rasp extends Model
{
    //
    protected $table = "rasp";
    protected $fillable = ["date", "pair_id","timetable_id", "room_id", "user_id"];

    
    function timetable() {
        return $this->hasOne('\App\Timetable', 'id', 'timetable_id');
    }
    
    function classroom() {
        return $this->hasOne('\App\Classroom', 'id', 'room_id');
    }   
    
    function teachers() {
        return "teachers";
    }
    
}
