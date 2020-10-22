<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Timetable extends Model
{
    // распределение времени и нагрузки
    protected $table = 'timetable';
    protected $fillable = ['group_id', 'teacher_id', 'change_teacher_id', 'block_id', 'start_at', 'hours', 'program_id','lessontype'];
    
    function teacher() {
        return $this->hasOne('App\User', 'id', 'teacher_id');
    }
    
    function change_teacher() {
        return $this->hasOne('App\User', 'id', 'change_teacher_id');
    }
    
    function block() {
        return $this->hasOne('\App\Block', 'id', 'block_id');
    }

    function discipline() {
        return $this->hasOne('\App\Discipline', 'id', 'discipline_id');
    }

    
    function group() {
        return $this->hasOne('\App\Group', 'id', 'group_id');
    }
    
    function journal() {
        return $this->hasOne('\App\Journal', 'timetable_id', 'id');
    }
    
    function classroom() {
        return $this->hasOne('\App\Classroom', 'id', 'room_id');
    }
    
    function rasp() {
        return $this->hasOne('\App\Rasp', 'id', 'rasp_id');
    }
    
    function teachers() {
        
        return $this->belongsToMany('\App\User', 'teachers2timetable', 'timetable_id', 'teacher_id');
    }           
    
    function lesson_type() {
        return $this->hasOne('\App\LessonType', 'id', 'lessontype');
    }
}
