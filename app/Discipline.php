<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Discipline extends Model
{
    //
    protected $fillable = ['name', 'active'];
    
    public function hours() {
        return 1;
    }
    
    
    public function blocks() {
        return $this->hasMany('\App\Block', 'discipline_id', 'id');
    }
    
    public function programs() {
        return $this->belongsToMany('\App\Program', 'discipline2program', 'discipline_id', 'program_id');
        
    }
}
