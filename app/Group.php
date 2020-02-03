<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    protected $table = "groups";
    protected $fillable = ['name', 'stream_id', 'description', 'active'];
    
    public function stream() {
        return $this->hasOne('stream', 'id', 'stream_id');
    }
    
    public function students() {
        return $this->hasMany('\App\Student', 'group_id', 'id');
    }
}
