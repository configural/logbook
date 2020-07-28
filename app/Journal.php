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
    
    public function rasp()
    {
        return $this->hasOne('\App\Rasp', 'id', 'rasp_id');
    }
    
    public function percent()
    {
    
    $group = unserialize($this->attendance);
    $total = count($group);
    $absent = 0;
    foreach($group as $g){
        if($g == 0) $absent++;
    }
    return round((($total - $absent)/$total), 2);
    }
}
