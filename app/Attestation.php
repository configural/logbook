<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attestation extends Model
{
    //
    protected $table = 'attestation';
    protected $fillable = ['name'];
}
