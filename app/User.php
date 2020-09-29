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
        'name', 'email', 'password', 'role', 'department_id', 'freelance'
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
    
    public function secname() {
        $tmp = explode(" ", $this->name);
        $secname = $tmp[0];
        return $secname;
    }
    
    public function fio() {
        $string = $this->name;
        $tmp = explode(" ", $string);
         $fam = $tmp[0];
        $name = "";
        $otch = "";
        if (isset($tmp[1])) {$name = mb_substr($tmp[1], 0, 1) . ".";}
        if (isset($tmp[2])) {$otch = mb_substr($tmp[2], 0, 1) . ".";}
        $fio = $fam . " " . $name . $otch;
        //dump($fio);
        return $fio;
    }
    
    public function timetable() {
        return $this->belongsToMany('\App\Timetable', 'teachers2timetable', 'teacher_id', 'timetable_id');
    }
    
    public function contracts() {
        return $this->hasMany('\App\Contract', 'user_id', 'id');
    }

    public static function user_hours($user_id, $date1, $date2, $lessontype) {
        //dump([$user_id, $date1, $date2, $lessontype]);
        $journal = \App\Journal::select(['journal.teacher_id', 'timetable.hours', 'rasp.date', 'rasp.start_at', 'rasp.finish_at', 'rasp.room_id'])
                ->distinct()
                ->join('rasp', 'journal.rasp_id', '=', 'rasp.id')
                ->join('timetable', 'rasp.timetable_id', '=', 'timetable.id')
                
                ->where('teacher_id', $user_id)
                ->whereBetween('rasp.date', [$date1, $date2])    
                ->where('timetable.lessontype', $lessontype)
                
                ->get();
                //->sum('timetable.hours');
        
        $hours = 0;
        foreach($journal as $j) {
            $hours += $j->hours;
        }
        
        //$hours = $journal;
        return $hours;
    }
    
    
}
