<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    //
    protected $table = "division";

    
    public function taxoffice() {
        return $this->hasOne("\App\Taxoffice", "id", "taxoffice_id");
    }
}
