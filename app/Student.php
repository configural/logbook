<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $table = 'students';
    
    protected $fillable = ['group_id', 'subgroup', 'secname', 'name', 'fathername', 'sono', 'qualification', 'edu_level', 'doc_number', 'doc_seria', 'doc_secname', 'status', 'division_id'];
    
    function students() {
        return hasMany('\App\Group', 'id', 'group_id');
    }
    
    function division() {
        return $this->hasOne('\App\Division', 'id', 'division_id');
    }
    
    function fio(){
        $fio = $this->secname . " " . $this->name . " " . $this->fathername;
        return $fio;
    }
}
