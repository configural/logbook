<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    //
    protected $fillable = ['name'];
    
    public function programs()
    {
        return $this->hasMany('\App\Programs', 'form_id', 'id');
    }
    
    
}
