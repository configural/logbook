<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vneaud extends Model
{
    //
    protected $table = 'vneaud';
    
    protected $fillable = [
        'user_id', 'group_id', 'lessontype_id', 'hours', 'date', 'description', 'count', 'contract_id'
    ];
    
    function user() {
        return $this->hasOne('\App\User', 'id', 'user_id');
    }
    
    function group() {
        return $this->hasOne('\App\Group', 'id', 'group_id');
    }
    
    function lessontype() {
        return $this->hasOne('\App\Lessontype', 'id', 'lessontype_id');
    }
}
