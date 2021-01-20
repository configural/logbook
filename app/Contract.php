<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    //
    protected $table = "contracts";
    protected $fillable = ["user_id", "name", "date","description", "price", "start_at", "finish_at", "active"];
 
    
    public function user() {
        return $this->hasOne('\App\User', 'id', 'user_id');
    }
}
