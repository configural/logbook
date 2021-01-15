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
    
        public static function largeblock_hours_distributed($id, $month1, $month2, $year = 2021) {
        $largeblock = Largeblock::find($id);
        $hours = 0;
        
        foreach($largeblock->blocks as $block) {
            $timetable = \App\Timetable::select()
                    ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                    ->join('groups', 'timetable.group_id', '=', 'groups.id')
                    ->join('streams', 'streams.id', '=', 'groups.stream_id')
                    ->whereBetween('timetable.month', [$month1, $month2])
                    ->where('teachers2timetable.timetable_id', '!=', NULL)
                    ->where('timetable.block_id', $block->id)
                    ->where('streams.year', $year)
                    ->get();
                        $hours += $timetable->sum('hours');



        };
        return $hours;
    }
    
        public static function largeblock_hours_undistributed($id, $month1, $month2, $year = 2021) {
        $largeblock = Largeblock::find($id);
        $hours = 0;
        $first_day = $year . '-' . $month1 . '-01';
        $last_day = $year . '-' . $month2 . '-' . cal_days_in_month ( CAL_GREGORIAN , $month2 , $year );
        
        foreach($largeblock->blocks as $block) {
            $timetable = \App\Timetable::selectRaw('streams.*, groups.*, timetable.*')
                    ->join('groups', 'timetable.group_id', '=', 'groups.id')
                    ->join('streams', 'streams.id', '=', 'groups.stream_id')
                    ->leftjoin('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                    ->where('teachers2timetable.id', NULL)
                    ->where('streams.date_start', '>=', $first_day)
                    ->where('streams.date_finish', '<=', $last_day)
                    ->where('timetable.block_id', $block->id)
                    ->where('streams.year', $year)
                    ->sum('hours');
                    
            $hours += $timetable;



        }
        return $hours;
    }
    
}
