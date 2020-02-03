<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    //
    protected $fillable = ['name', 'description', 'hours', 'form_id', 'active'];
    
    public function form() {
        return $this->hasOne('\App\Form', 'id', 'form_id');
    }
    
    public function attestation() {
        return $this->hasOne('\App\Attestation', 'id', 'attestation_id');
    }
    
    public function disciplines() {
        return $this->belongsToMany('\App\Discipline', 'discipline2program', 'program_id', 'discipline_id');
    }
    
    public function hours() {
        $hours = 0;
        foreach($this->disciplines as $discipline) {
            $hours += $discipline->blocks->sum('l_hours');
            $hours +=  $discipline->blocks->sum('p_hours');
            $hours +=  $discipline->blocks->sum('s_hours');
        };
        return $hours;
    }
    
    
}
