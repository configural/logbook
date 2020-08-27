<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $table = 'students';
    
    protected $fillable = ['group_id', 'secname', 'name', 'fathername', 'sono', 'qualification', 'edu_level', 'doc_number', 'doc_seria', 'doc_secname', 'status'];
    
    function students() {
        return hasMany('\App\Group', 'id', 'group_id');
    }
    
    function fio(){
        $fio = $this->secname . " " . $this->name . " " . $this->fathername;
        return $fio;
    }
}
