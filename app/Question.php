<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $table = "questions";
    protected $fillable = [
        "test_id", "name", "a0", "a1", "a2", "a3", "a4", "a5", "a6", "a7",
        "a8", "a9", "key"
    ];
    
    function questiontype() {
        return $this->hasOne('\App\QuestionType', 'id', 'questiontype_id');
    }
}
