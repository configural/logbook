<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Stream extends Model
{
    //
    protected $table = 'streams';
    protected $fillable = ['name', 'year', 'date_start', 'date_finish', 'metodist_id', 'active'];
    

    public function programs() {
        return $this->belongsToMany('\App\Program', 'programs2stream', 'stream_id', 'program_id');
        
    }
    
    public function groups() {
        return $this->hasMany('\App\Group', 'stream_id', 'id');
    }
    
    public function metodist() {
        return $this->hasOne('\App\User', 'id', 'metodist_id');
    }
    
}
