<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\course;
use App\schedule_maker;
use App\time_slot;
use App\course_appointment;
use App\room;
use Illuminate\Support\Facades\DB;

class scheduleMaker extends Controller
{
    //
    private static $break_time_mon = "mon_break";
    private static $break_time_sun = "sun_break";
    

    private function getCoursesMultipleSections($start_date, $end_date){
        $courses = course::all();
        $course_multiple_sections = array();
        $index = 0;
        $array_dates = $this->getDatesBetween(strtotime($start_date), strtotime($end_date));
        foreach($courses as $course){
            if($this->checkCourseScheduledByDate($start_date, $end_date, $course->id)){
                continue;
            }
            $courseSections = course_appointment::where("course_id", '=', $course->id)->get();
            $sectionsCount = $courseSections->count();
            if($sectionsCount == 1){
                $schedule_maker = new schedule_maker();
                $schedule_maker->course_id = $course->id;
                $schedule_maker->room_id = $courseSections[0]->room_id;
                $schedule_maker->time_slot_id = $courseSections[0]->time_slot_id;
                $exam_date = $this->getSuitableExamDate(0, count($array_dates), $array_dates, $course, 0);
                $schedule_maker->exam_date = $exam_date;
                $schedule_maker->save();
            }else{
                $course_multiple_sections[$index++] = $course;
            }
        }
        foreach($course_multiple_sections as $course){
            $courseSections = course_appointment::where("course_id", '=', $course->id)->get();
            $exam_date = $this->getSuitableExamDate(0, count($array_dates), $array_dates, $course, 0);
            $ava_rooms = $this->getNumberOfRoomsAvailable($exam_date);
            $size = count($ava_rooms);
            $day = date('w', strtotime($exam_date));
            if(in_array($day, [1, 3])){// Mon and Wed
                $time_slot_id = time_slot::select('id')->where('day', '=', $this::$break_time_mon)->get()[0]->id;
            }else{
                $time_slot_id = time_slot::select('id')->where('day', '=', $this::$break_time_sun)->get()[0]->id;
            }
            foreach($courseSections as $section){
                $schedule_maker = new schedule_maker();
                $schedule_maker->course_id = $course->id;
                $schedule_maker->exam_date = $exam_date;
                $rand_room = rand(0, $size - 1);
                $room_id = $ava_rooms[$rand_room];
                $ava_rooms[$rand_room] = $ava_rooms[$size - 1];
                $size--;
                $schedule_maker->room_id = $room_id;
                $schedule_maker->time_slot_id = $time_slot_id;
                $schedule_maker->save();
            }
        }
    }

    private function getNumberOfRoomsAvailable($date){
        $rooms = room::all();
        $rooms_reserved = schedule_maker::select('room_id')->where('exam_date', '=', $date)->distinct()->get()->toArray();
        $rooms_available = array();
        $i = 0;
        foreach($rooms as $room){
            if(!in_array($room->id, $rooms_reserved)){
                $rooms_available[$i++] = $room->id;
            }
        }
        return $rooms_available;
    }

    private function getCoursesSpecificDate($date){
        $courses_in_this_date = schedule_maker::where('exam_date', '=', $date)->get();
        return $courses_in_this_date;
    }

    private function getSuitableExamDate($low, $high, $array_dates, $course, $number_of_sections){
        $mid = floor(($low + $high) / 2);
        $curr_date = $array_dates[$mid];
        $courses_in_this_date = $this->getCoursesSpecificDate($curr_date);
        $dist = $this->getMinDistance($course, $courses_in_this_date);
        print($dist.'  ----  ');
        if($dist > 1){
            if($number_of_sections !=0){
                $ava_rooms = $this->getNumberOfRoomsAvailable($curr_date);
                if($ava_rooms >= $number_of_sections){
                    return $curr_date;
                }
            }else{
                return $curr_date;
            }
        }
        $value = rand(0,1) == 1;
        if($value){
            return $this->getSuitableExamDate($mid, $high, $array_dates, $course, $number_of_sections);
        }
        if($mid > 0){
            return $this->getSuitableExamDate($low, $mid - 1, $array_dates, $course, $number_of_sections);
        }
    }

    private function getDatesBetween($start_date, $end_date){
        $array_dates = array();
        $index = 0;
        for($i = $start_date; $i <= $end_date; $i = $i + 86400){
            if(date('w', $i) == 5 || date('w', $i) == 6) {
                continue;
            }
            $array_dates[$index++] = date("Y-m-d", $i);
        }
        return $array_dates;
    }

    private function getMinDistance($curr_course, $other_courses){
        $min_distance = 10;
        //print($other_courses.'                   ');
        foreach($other_courses as $cs){
            $cs_info = course::where('id', '=', $cs->course_id)->get()[0];
            if($curr_course->major_id != $cs_info->major_id){
                continue;
            }
            $curr_academic_year = $curr_course->academic_year / 10;
            $oth_academic_year = $cs_info->academic_year / 10;
            $dist = sqrt(pow($curr_academic_year, 2) - pow($oth_academic_year, 2));
            if($dist < $min_distance){
                $min_distance = $dist;
            }
        }
        return $min_distance;
    }

    private function checkCourseScheduledByDate($start_date, $end_date, $course_id){
        $result = schedule_maker::where('course_id', '=', $course_id)->whereBetween('exam_date', [$start_date, $end_date])->get()->toArray();
        return !empty($result);
    }



    public function generateAutomaticSchedule(Request $request){
        /*
        Steps to generate:
        1- take the course info.
        2- check if it has more than one section.
        3- if it has more than one, then check the avaliability for rooms.
        4- if there is enough 
        */
        // Get all courses.
        $courses = course::all();
        $this->getCoursesMultipleSections($request->start_date, $request->end_date);
        $data = DB::table('schedule_maker')
                    ->join('course', 'schedule_maker.course_id', '=', 'course.id')
                    ->join('room', 'schedule_maker.room_id', '=', 'room.id')
                    ->join('time_slot', 'schedule_maker.time_slot_id', '=', 'time_slot.id')
                    ->paginate(10);

        return redirect()->back()->with('success', $data);
        //return $data;
    }
}
