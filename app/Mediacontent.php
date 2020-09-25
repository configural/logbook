<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mediacontent extends Model
{
    //
    protected $table = "mediacontent";
    
    protected $fillable = ['type', 'name', 'description', 'date_start', 'date_finish', 'status', 'master_id', 'result_path'];
    
    public function mediatype() {
        return $this->hasOne('\App\Mediatype', 'id', 'type');
    }
    
    public function users(){
        return $this->belongsToMany('\App\User', 'media2users', 'media_id', 'user_id');
    }
            
}
