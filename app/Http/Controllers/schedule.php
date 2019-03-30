<?php

namespace App\Http\Controllers;

use App\course_appointment;
use App\time_slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class schedule extends Controller
{
  public function GetAvailableTime(Request $request){
      $course = $request->course_id;
      $day = $request->day_id;
      $room = $request->room_id;

      $course_appointment = course_appointment::where('room_id',$room)->get();
      $time_slot_id = [];
      for($i = 0 ; $i < count($course_appointment) ; $i++){
          array_push($time_slot_id,$course_appointment[$i]->time_slot_id );
      }

      if(count($course_appointment) > 0)
          $time_slot = time_slot::whereNotIn('id',$time_slot_id)->where('day',$day)->get();
      else
          $time_slot = time_slot::where('day',$day)->get();

      return json_encode($time_slot);
  }

  public function addCourseToSchedule(Request $request){
      $course_id = Input::get('course_select');
      $time_slot_id =  Input::get('time_slot_select');
      $room_id =  Input::get('room_id');

      $course_appointment = new course_appointment();
      $course_appointment->course_id = $course_id;
      $course_appointment->time_slot_id = $time_slot_id;
      $course_appointment->room_id = $room_id;
      if($course_appointment->save()){
          session()->flash("success","New Appointment Added Successfully ");
      }else{
          session()->flash("errors","Some thing that be wrong !");
      }
      return redirect()->back();
  }
}
