<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'description', 'hours', 'form_id', 'active', 'attestation_id', 'attestation_hours', 'vkr_hours'];
    
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
                $hours += $discipline->attestation_hours;
        };
        $hours += $this->attestation_hours;
        return $hours;
    }
    
    
}
