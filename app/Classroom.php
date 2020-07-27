<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;


class Classroom extends Model
{
    // аудитории
    protected $table = "classrooms";
    protected $fillable = ["name", "address", "description", "capacity"];
    
    public static function is_blocked($date, $room_id) {
        $user_id = \Illuminate\Support\Facades\Auth::user()->id;
        $block = DB::table('block_rooms')->select('user_id')->where('date', $date)->where('room_id', $room_id)->first();
        
        if (empty($block->user_id)) {
        return false;} else {
        return $block->user_id;
        }
    }
    
    public static function block_classroom($date, $room_id) {
        $user_id = \Illuminate\Support\Facades\Auth::user()->id;
        DB::table('block_rooms')->insert(["date" => $date, "room_id" => $room_id, "user_id" => $user_id]);
    }
    
    public static function unblock_classroom($date, $room_id) {
        $user_id = \Illuminate\Support\Facades\Auth::user()->id;
        DB::table('block_rooms')->where(["date" => $date, "room_id" => $room_id, "user_id" => $user_id])->delete();
        
    }
}
