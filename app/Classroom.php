<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    //
    protected $table = "classrooms";
    protected $filleble = ["name", "address", "description"];
}
