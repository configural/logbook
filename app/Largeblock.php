<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Largeblock extends Model
{
    // Укрупненные темы
    protected $fillable = ['name', 'active', 'department_id'];
    
    public function blocks() {
        return $this->hasMany('\App\Block', 'largeblock_id', 'id');
    }

    public function department() {
        return $this->hasOne('\App\Department', 'id', 'department_id');
    }
    
    
    public static function largeblock_hours($id, $date1, $date2) {
        $largeblock = Largeblock::find($id);
        $hours = 0;
        foreach($largeblock->blocks as $block) {
            $timetable = \App\Timetable::select()
                    //->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                    ->join('groups', 'timetable.group_id', '=', 'groups.id')
                    ->join('streams', 'streams.id', '=', 'groups.stream_id')
                    ->whereBetween('streams.date_start', [$date1, $date2])
                    ->where('block_id', $block->id)
                    
                    ->get();
            $hours += $timetable->sum('hours');

        };
        return $hours;
    }
    
        public static function largeblock_hours_distributed($id, $date1, $date2) {
        $largeblock = Largeblock::find($id);
        $hours = 0;
        foreach($largeblock->blocks as $block) {
            $timetable = \App\Timetable::select()
                    ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                    ->join('groups', 'timetable.group_id', '=', 'groups.id')
                    ->join('streams', 'streams.id', '=', 'groups.stream_id')
                    ->whereBetween('streams.date_start', [$date1, $date2])
                    ->where('teachers2timetable.timetable_id', '!=', NULL)
                    ->where('timetable.block_id', $block->id)
                    ->where('teachers2timetable.teacher_id', '!=', NULL)

                    ->get();
                        $hours += $timetable->sum('hours');



        };
        return $hours;
    }
    
        public static function largeblock_hours_undistributed($id, $date1, $date2) {
        $largeblock = Largeblock::find($id);
        $hours = 0;
  /*
   *                         @foreach(\App\Timetable::selectRaw('streams.*, groups.*, timetable.*')
                                                    ->join('groups', 'groups.id', '=', 'timetable.group_id')
                                                    ->join('streams', 'streams.id', '=', 'groups.stream_id')
                                                    ->leftjoin('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                                                    ->where('teachers2timetable.id', NULL)
                                                    ->where('streams.year', $year)
                                                    ->limit(2000)
                                                    ->get() as $timetable) 
   */
        foreach($largeblock->blocks as $block) {
            $timetable = \App\Timetable::selectRaw('streams.*, groups.*, timetable.*')
                    ->join('groups', 'timetable.group_id', '=', 'groups.id')
                    ->join('streams', 'streams.id', '=', 'groups.stream_id')
                    ->leftjoin('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                    ->whereBetween('streams.date_start', [$date1, $date2])
                    ->where('teachers2timetable.id', NULL)
                    ->where('timetable.block_id', $block->id)
                    ->sum('hours');
                    
            $hours += $timetable;



        }
        return $hours;
    }
    
}
