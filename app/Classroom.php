<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    // аудитории
    protected $table = "classrooms";
    protected $fillable = ["name", "address", "description"];
}
