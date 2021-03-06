<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'description', 'hours', 'form_id', 'active', 'attestation_id', 'attestation_hours', 'vkr_hours', 'project_hours','year'];
    
    public function form() {
        return $this->hasOne('\App\Form', 'id', 'form_id');
    }
    
    public function attestation() {
        return $this->hasOne('\App\Attestation', 'id', 'attestation_id');
    }
    
    public function disciplines() {
        return $this->belongsToMany('\App\Discipline', 'discipline2program', 'program_id', 'discipline_id')->orderBy('name');
    }
    
    public function hours() {
        $hours = 0;
        foreach($this->disciplines as $discipline) {
            
                $hours += $discipline->active_blocks->sum('l_hours');
                $hours +=  $discipline->active_blocks->sum('p_hours');
                $hours +=  $discipline->active_blocks->sum('s_hours');
                $hours +=  $discipline->active_blocks->sum('w_hours');
                $hours += $discipline->attestation_hours;
        };
        $hours += $this->attestation_hours;
        $hours += $this->project_hours;
        return $hours;
    }
    

    public function inTimetable() {
        $in_timetable = false;
        
        foreach ($this->disciplines as $d):
            foreach($d->blocks as $b) :
                if($timetable = \App\Timetable::whereNotNull('rasp_id')
                        ->where(['block_id' => $b->id])
                        ->first()
                        ) :
                    //echo $b->name  $timetable->rasp->date;
                    $in_timetable = true;
                    //break;
                endif;
            endforeach;
            if ($in_timetable === true) :
                //break;
            endif;
        endforeach;
        if ($in_timetable):
            
        endif;
        return $in_timetable;
    }
}
