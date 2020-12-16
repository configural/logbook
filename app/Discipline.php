<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Discipline extends Model
{
    //
    protected $fillable = ['name', 'active', 'hours', 'department_id', 'attestation_id', 'attestation_hours'];
    
    
    
    public function department() {
        return $this->hasOne('\App\Department', 'id', 'department_id');
        
    }
    
    public function blocks() {
        return $this->hasMany('\App\Block', 'discipline_id', 'id');
    }
    
    public function active_blocks() {
        return $this->hasMany('\App\Block', 'discipline_id', 'id')->where('active', 1)->orderBy('name');
    }
    
    public function programs() {
        return $this->belongsToMany('\App\Program', 'discipline2program', 'discipline_id', 'program_id');
        
    }
    
    function l_hours_total() {
        return $this->active_blocks->sum('l_hours');
    }
    
    function p_hours_total() {
        return $this->active_blocks->sum('p_hours');
    }
    
    function s_hours_total() {
        return $this->active_blocks->sum('s_hours');
    }
    
    function w_hours_total() {
        return $this->active_blocks->sum('w_hours');
    }
    
    function hours_total() {
        return $this->active_blocks->sum('s_hours') + $this->active_blocks->sum('p_hours') + $this->active_blocks->sum('w_hours') +  $this->active_blocks->sum('l_hours') + $this->attestation_hours;
    }
    
    static function hours_by_discipline_id($id, $date1, $date2, $department_id = 0) {
        $discipline = Discipline::select()->where('id', $id)->get();
        $s1  = 0;
        $s2  = 0;
        foreach ($discipline as $d) {
            foreach($d->blocks as $b){
              //  echo $b->id . "<br>";
                $kaf_blocks = \App\Timetable::select(['disciplines.department_id as d' , 'blocks.department_id as b'])
                        
                        ->where('block_id', $b->id)
                        ->join('blocks', 'blocks.id', '=', 'timetable.block_id')
                        ->join('disciplines', 'disciplines.id', '=', 'blocks.discipline_id')
                        ->join('groups', 'groups.id', '=', 'timetable.group_id')
                        ->join('streams', 'groups.stream_id', '=', 'streams.id')
                        ->whereBetween('streams.date_start', [$date1, $date2])
                        ->where(function($query) use ($department_id){
                            $query->where('blocks.department_id', $department_id)
                                   ->where('disciplines.department_id', '!=', 'blocks.department_id');
                        });

                $kaf_disciplines = \App\Timetable::select(['disciplines.department_id as d' , 'blocks.department_id as b'])
                        
                        ->where('block_id', $b->id)
                        ->join('blocks', 'blocks.id', '=', 'timetable.block_id')
                        ->join('disciplines', 'disciplines.id', '=', 'blocks.discipline_id')
                        ->join('groups', 'groups.id', '=', 'timetable.group_id')
                        ->join('streams', 'groups.stream_id', '=', 'streams.id')
                        ->whereBetween('streams.date_start', [$date1, $date2])
                        ->where(function($query) use ($department_id){
                            $query->where('disciplines.department_id', $department_id)
                                   ->where('blocks.department_id', NULL)
                                    ;
                        });        
                        
                      //  dd($timetable);
                //dump($timetable);
                //$hours += $timetable->sum('timetable.hours');
                        
                        $s1 += $kaf_blocks->sum('timetable.hours');
                        
                        $s2 += $kaf_disciplines->sum('timetable.hours');
                
            }
        }
            
        
        return $s1 + $s2;
        
    }
    
}

