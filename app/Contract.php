<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    //
    protected $table = "contracts";
    protected $fillable = ["user_id", "name", "description", "price", "start_at", "finish_at", "active"];
    
}
