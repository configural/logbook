<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    //
    protected $table = "tests";
    protected $fillable = [
        "name", "active"
    ];
    

    function questions() {
        return $this->hasMany('\App\Question', 'test_id', 'id');
    }
    
    function streams() {
        return $this->belongsToMany('\App\Stream', 'tests2streams', 'test_id', 'stream_id');
    }
}
