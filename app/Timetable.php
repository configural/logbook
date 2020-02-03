<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    //
    protected $table = 'timetable';
    protected $fillable = ['group_id', 'teacher_id', 'change_teacher_id', 'block_id', 'start_at', 'hours'];
    
    function teacher() {
        return $this->hasOne('App\User', 'id', 'teacher_id');
    }
    
    function change_teacher() {
        return $this->hasOne('App\User', 'id', 'change_teacher_id');
    }
    
    function block() {
        return $this->hasOne('\App\Block', 'id', 'block_id');
    }
    
    function group() {
        return $this->hasOne('\App\Group', 'id', 'group_id');
    }
    
    function journal() {
        return $this->hasOne('\App\Journal', 'timetable_id', 'id');
    }
    
    
}
