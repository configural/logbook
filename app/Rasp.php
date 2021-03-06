<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
    
    function journal(){
        return $this->hasOne('\App\Journal', 'rasp_id', 'id');
    }
    
    
    public static function weekday($date) {
        
        $index = (int) Carbon::parse($date)->format('w');
        $day = array("воскресенье", "понедельник", "вторник", "среда", "четверг", "пятница", "суббота");
        return $day[$index];
    }
}
