<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    //
    protected $fillable = ['name', 'description', 'hours', 'form_id', 'active'];
    
    public function form() {
        return $this->hasOne('\App\Form', 'id', 'form_id');
    }
}
