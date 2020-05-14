<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Discipline extends Model
{
    //
    protected $fillable = ['name', 'active', 'hours'];
    
    
    

    
    public function blocks() {
        return $this->hasMany('\App\Block', 'discipline_id', 'id');
    }
    
    public function active_blocks() {
        return $this->hasMany('\App\Block', 'discipline_id', 'id')->where('active', 1);
    }
    
    public function programs() {
        return $this->belongsToMany('\App\Program', 'discipline2program', 'discipline_id', 'program_id');
        
    }
}
