<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Discipline extends Model
{
    //
    protected $fillable = ['name', 'active'];
    
    public function blocks() {
        return $this->hasMany('\App\Block', 'discipline_id', 'id');
    }
}
