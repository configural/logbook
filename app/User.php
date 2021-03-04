<?php

namespace App;
use Illuminate\Support\Facades\DB;
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
        'name', 'email', 'password', 'role', 'department_id', 'freelance', 'table_number', 'staff'
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
      return $this->hasMany('\App\Journal', 'teacher_id', 'id')->whereYear('created_at', date('Y'));
        
    }
    

/*
 * Фамилия пользователя
 */
   public function secname() {
        $tmp = explode(" ", $this->name);
        $secname = $tmp[0];
        return $secname;
    }

    
/*
 * ФИО пользователя
 */    
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
    
    
 /*
  * расписание преподавателя
  */
    public function timetable() {
        return $this->belongsToMany('\App\Timetable', 'teachers2timetable', 'teacher_id', 'timetable_id');
    }
    
 
/*
 * Договоры преподавателя
 */    
    public function contracts() {
        return $this->hasMany('\App\Contract', 'user_id', 'id');
    }

    
 /*
 * Возвращает количество часов преподавателя за определенный период на основании журнала (фактически проведенных)
 * user_id - ИД пользователя
 * date1 - начало периода
 * date2 - конец периода
 * lessontype - тип занятия
 */
    public static function user_hours_journal($user_id, $date1, $date2, $lessontype) {
        $journal = \App\Journal::select(['journal.teacher_id', 'timetable.hours', 'rasp.date', 'rasp.start_at', 'rasp.finish_at', 'rasp.room_id'])
                ->distinct()
                ->join('rasp', 'journal.rasp_id', '=', 'rasp.id')
                ->join('timetable', 'rasp.timetable_id', '=', 'timetable.id')
                ->where('teacher_id', $user_id)
                ->whereBetween('rasp.date', [$date1, $date2])    
                ->where('timetable.lessontype', $lessontype)
                ->get();
       
        $hours = 0;
        foreach($journal as $j) {
            $hours += $j->hours;
        }
    return $hours;
    }
    


/*
 * Возвращает количество часов преподавателя за определенный период на основании расписания
 * user_id - ИД пользователя
 * date1 - начало периода
 * date2 - конец периода
 * lessontype - тип занятия
 */
    public static function user_hours_rasp($user_id, $month, $year, $lessontype, $form_id = -1) {
        //dump([$user_id, $month, $year, $lessontype]);
        $date1 = $year . "-" . sprintf("%02d", $month) . "-01";
        $date2 = $year . "-" . sprintf("%02d", $month) . "-" . cal_days_in_month(CAL_GREGORIAN, $month, $year);;
        
        //dump([$date1, $date2]);
        
        if ($form_id == -1) {
        
        $tmp = \App\Timetable::select(['timetable.hours', 'timetable.lessontype', 'rasp.date', 'rasp.start_at', 'rasp.finish_at', 'rasp.room_id' ])
                ->distinct()
                ->join('rasp', 'timetable.rasp_id', '=', 'rasp.id')
                ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                ->join('groups', 'groups.id', '=', 'timetable.group_id')
                ->join('streams', 'streams.id', '=', 'groups.stream_id')
                ->join('programs2stream', 'programs2stream.stream_id', '=', 'streams.id')
                ->join('programs', 'programs.id', '=', 'programs2stream.program_id')
                ->where('teachers2timetable.teacher_id', '=', $user_id)
                ->whereBetween('rasp.date', [$date1, $date2])    
                ->where('timetable.lessontype', $lessontype)
                
                ->get();
        } else {
            
         $tmp = \App\Timetable::select(['timetable.hours', 'timetable.lessontype', 'rasp.date', 'rasp.start_at', 'rasp.finish_at', 'rasp.room_id' ])
                ->distinct()
                ->join('rasp', 'timetable.rasp_id', '=', 'rasp.id')
                ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                ->join('groups', 'groups.id', '=', 'timetable.group_id')
                ->join('streams', 'streams.id', '=', 'groups.stream_id')
                ->join('programs2stream', 'programs2stream.stream_id', '=', 'streams.id')
                ->join('programs', 'programs.id', '=', 'programs2stream.program_id')
                ->where('teachers2timetable.teacher_id', '=', $user_id)
                ->whereBetween('rasp.date', [$date1, $date2])    
                ->where('timetable.lessontype', $lessontype)
                ->where('programs.form_id', $form_id)           
                 ->get();
        }
        $hours = 0;
        
        
        //dump($tmp);
        
        foreach($tmp as $t) {
            $hours += $t->hours;
            
            //dump($t->form_id);
            
        }
        return $hours;
    }

    public static function user_hours_vneaud ($user_id, $month, $year, $lessontype_id, $form_id = -1) {
        //dump([$user_id, $month, $year, $lessontype_id]);
        if ($form_id == -1) {
                 $vneaud = \App\Vneaud::select('vneaud.hours')
                ->where('user_id', $user_id)
                ->join('groups', 'groups.id', '=', 'vneaud.group_id')
                ->join('streams', 'streams.id', '=', 'groups.stream_id')
                ->join('programs2stream', 'programs2stream.stream_id', '=', 'streams.id')
                ->join('programs', 'programs.id', '=', 'programs2stream.program_id')
                ->whereMonth('date', $month)
                ->where('lessontype_id', $lessontype_id)
                ->sum('vneaud.hours');  
        }
        else {
        $vneaud = \App\Vneaud::select('vneaud.hours')
                ->where('user_id', $user_id)
                ->join('groups', 'groups.id', '=', 'vneaud.group_id')
                ->join('streams', 'streams.id', '=', 'groups.stream_id')
                ->join('programs2stream', 'programs2stream.stream_id', '=', 'streams.id')
                ->join('programs', 'programs.id', '=', 'programs2stream.program_id')
                ->whereMonth('date', $month)
                ->where('lessontype_id', $lessontype_id)
                ->where('programs.form_id', $form_id)
                ->sum('vneaud.hours');
        }
        return $vneaud;
        
    }

    
     public static function user_workload_groups_vneaud($user_id, $month, $year = 2021, $lessontype) {

        $groups_array = \App\Timetable::select('timetable.*')
                ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                ->join('groups', 'timetable.group_id', '=', 'groups.id')
                ->join('streams', 'streams.id', '=', 'groups.stream_id')
                ->where('timetable.month', $month)
                ->where('streams.year', $year)
                ->where('teachers2timetable.teacher_id', '=', $user_id)
                ->where('timetable.lessontype', $lessontype)
                ->get();
        
        return $groups_array;
        
    }   
    
    
    public static function user_hours_workload($user_id, $month, $year = 2021, $lessontype) {
        $tmp = \App\Timetable::select('timetable.hours')
                ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                ->join('groups', 'timetable.group_id', '=', 'groups.id')
                ->join('streams', 'streams.id', '=', 'groups.stream_id')
                ->where('timetable.month', $month)
                ->where('streams.year', $year)
                ->where('teachers2timetable.teacher_id', '=', $user_id)
                ->where('timetable.lessontype', $lessontype)
                ->get();
        $hours = 0;
        foreach($tmp as $t) {
            $hours += $t->hours;
        }
        return $hours;
    }    
    

    public static function user_workload_groups($user_id, $month, $year = 2021, $lessontype) {

        $groups_array = \App\Timetable::select('timetable.*')
                ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                ->join('groups', 'timetable.group_id', '=', 'groups.id')
                ->join('streams', 'streams.id', '=', 'groups.stream_id')
                ->where('timetable.month', $month)
                ->where('streams.year', $year)
                ->where('teachers2timetable.teacher_id', '=', $user_id)
                ->where('timetable.lessontype', $lessontype)
                ->get();
        
        return $groups_array;
        
    }

/*
 * Возвращает количество часов преподавателя за определенный период на основании расписания буз учета типа занятия
 * user_id - ИД пользователя
 * date1 - начало периода
 * date2 - конец периода
 */
public static function rasp($user_id, $date1, $date2) {
        $tmp = \App\Timetable::select(['timetable.hours', 'timetable.lessontype', 'rasp.date', 'rasp.start_at', 'rasp.finish_at', 'rasp.room_id' ])
                ->distinct()
                ->join('rasp', 'timetable.rasp_id', '=', 'rasp.id')
                ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                ->where('teachers2timetable.teacher_id', '=', $user_id)
                ->whereBetween('rasp.date', [$date1, $date2])    
                ->get();
        $hours = 0;
        foreach($tmp as $t) {
            $hours += $t->hours;
        }
        return $hours;
    }

    
    public static function user_price($user_id, $date1, $date2, $lessontype) {

    }


   

    
}
