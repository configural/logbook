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

    
    public static function largeblock_hours($id, $date1, $date2) {
        $largeblock = Largeblock::find($id);
        $hours = 0;
        foreach($largeblock->blocks as $block) {
            $timetable = \App\Timetable::selectRaw('sum(hours) as hours, timetable.id, timetable.group_id')
                    ->distinct('timetable.id')
                    ->join('groups', 'timetable.group_id', '=', 'groups.id')
                    ->join('streams', 'streams.id', '=', 'groups.stream_id')
                     ->groupby('timetable.id')
                    ->groupby('timetable.group_id')
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
            $timetable = \App\Timetable::selectRaw('sum(hours) as hours, timetable.id, timetable.group_id')
                    ->distinct('timetable.group_id')
                    ->distinct('teachers2timetable.teacher_id')
                    ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                    ->join('groups', 'timetable.group_id', '=', 'groups.id')
                    ->join('streams', 'streams.id', '=', 'groups.stream_id')
                    ->groupby('timetable.id')
                    ->groupby('timetable.group_id')

                    ->whereBetween('streams.date_start', [$date1, $date2])
                    ->where('timetable.id', '!=', NULL)
                    ->where('block_id', $block->id)
                    
                    ->where('timetable.subgroup', NULL)
                    ->get();
                        $hours += $timetable->sum('hours');



        };
        return $hours;
    }
    
}
