<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
    //
    protected $table = 'change_log';
    
    public function user()
    {
        return $this->hasOne('\App\User', 'id', 'user_id');
    }
    
    public static function add($table_name, $item_id, $method)
    {
        $changelog = new ChangeLog();
        $changelog->user_id = Auth::user()->id;
        $changelog->table_name = $table_name;
        $changelog->item_id = $item_id;
        $changelog->method = $method;
        $changelog->save();
        
    }
    
}
