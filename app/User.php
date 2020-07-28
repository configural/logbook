<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'department_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function role() {
            return $this->hasOne('App\Role', 'id', 'role_id');
    }
    
    public function department() {
            return $this->hasOne('App\Department', 'id', 'department_id');
    }
    
    public function journal() {
        return $this->hasMany('\App\Journal', 'teacher_id', 'id');
    }
}
