<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    //
    protected $table = "contracts";
    protected $fillable = ["user_id", "name", "date", "description", "price", "start_at", "finish_at", "active", "hours"];
 
    
    public function user() {
        return $this->hasOne('\App\User', 'id', 'user_id');
    }
    
    function hours_left() {
       
        /*select distinct contracts.id, timetable.lessontype, timetable.hours, rasp.date, rasp.start_at, rasp.finish_at, rasp.room_id 
         * from contracts 
         * join teachers2timetable on teachers2timetable.contract_id=contracts.id 
         * join timetable on teachers2timetable.timetable_id=timetable.id 
         * join rasp on rasp.id=timetable.rasp_id 
         * where contracts.id=2*/
        
        
        $hours_contract = \App\Contract::selectRaw('contracts.id, timetable.hours, timetable.lessontype, rasp.date, rasp.start_at, rasp.finish_at, rasp.room_id')
                ->distinct()
                ->join('teachers2timetable', 'teachers2timetable.contract_id', '=', 'contracts.id')
                ->join('timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                ->join('rasp', 'rasp.id', '=', 'timetable.rasp_id')
                ->where('contracts.id', $this->id)
                ->whereBetween('rasp.date', [$this->start_at, $this->finish_at])
                ->get();
        $hours = 0;
        foreach ($hours_contract as $h) {
            $hours += $h->hours;
        }
         //dd($hours);   
         // */
        
        return $this->hours - $hours;
                
    }
}
