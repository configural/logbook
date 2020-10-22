<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Discipline extends Model
{
    //
    protected $fillable = ['name', 'active', 'hours', 'department_id', 'attestation_id', 'attestation_hours'];
    
    
    
    public function department() {
        return $this->hasOne('\App\Department', 'id', 'department_id');
        
    }
    
    public function blocks() {
        return $this->hasMany('\App\Block', 'discipline_id', 'id');
    }
    
    public function active_blocks() {
        return $this->hasMany('\App\Block', 'discipline_id', 'id')->where('active', 1)->orderBy('name');
    }
    
    public function programs() {
        return $this->belongsToMany('\App\Program', 'discipline2program', 'discipline_id', 'program_id');
        
    }
    
    function l_hours_total() {
        return $this->active_blocks->sum('l_hours');
    }
    
    function p_hours_total() {
        return $this->active_blocks->sum('p_hours');
    }
    
    function s_hours_total() {
        return $this->active_blocks->sum('s_hours');
    }
    
    function w_hours_total() {
        return $this->active_blocks->sum('w_hours');
    }
    
    function hours_total() {
        return $this->active_blocks->sum('s_hours') + $this->active_blocks->sum('p_hours') + $this->active_blocks->sum('w_hours') +  $this->active_blocks->sum('l_hours') + $this->attestation_hours;
    }
    
}

