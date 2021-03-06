<?php

namespace App;

use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    //
    protected $table = "journal";
    
    protected $fillable = ['timetable_id', 'teacher_id', 'l_hours', 'p_hours', 'attendance', 'attestation'];
    
    public function timetable() {
        return $this->hasOne('\App\Timetable', 'id', 'timetable_id');
    }
    
    public function user() {
        return $this->hasOne('\App\User', 'id', 'teacher_id');
    }
    
    public static function state($rasp_id) {
        $journal = \App\Journal::where('rasp_id', $rasp_id)->where('teacher_id', Auth::user()->id)->first();
        //dump($journal);
        $state = 0;
        $tmp = @unserialize($journal->attendance);
        if ($tmp) $state = 1;
        return $state;
    }
    
    
    
    public static function teacher($rasp_id) {
        $journal = \App\Journal::where('rasp_id', $rasp_id)->first();
        $teacher = \App\User::find($journal->teacher_id);
        return $teacher->fio();
    }
    
    
    
    public function rasp()
    {
        return $this->hasOne('\App\Rasp', 'id', 'rasp_id');
    }
    
    public function percent()
    {
    if ($this->attendance) {
    $group = unserialize($this->attendance);
    if (count($group)){
    $total = count($group);
    $absent = 0;
    foreach($group as $g){
        if($g == 0) $absent++;
    }
    return round((($total - $absent)/$total), 2);
    }} else {
        return 0;
    }
    }
}
