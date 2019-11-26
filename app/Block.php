<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    //
    protected $fillable = ['name', 'discipline_id', 'active'];
    
    public function Discipline() {
        return $this->hasOne('Discipline', 'id', 'discipline_id');
    }
 
}
