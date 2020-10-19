<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    //
    protected $fillable = [
        'name', 'description', 'start_at', 'finish_at', 'date', 'hours', 'webinar_link', 'record_link', 'metodist_id'
    ];

    function teachers() {
        return $this->belongsToMany('\App\User', 'webinars2teachers', 'webinar_id', 'user_id');
    }
    
    function groups() {
        return $this->belongsToMany('\App\Group', 'webinars2groups', 'webinar_id', 'group_id');
    }
    
    function metodist() {
        return $this->hasOne('\App\User', 'id', 'metodist_id');
    }
    
}
