<?php

namespace App\Http\Controllers;

use App\major;
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
    private static $sun_days_array = [0, 2, 4];

    /*
    ####################
    # Helper functions #
    ####################
    */

    private function getCoursesMultipleSections($start_date, $end_date, $vacation_dates){
        $courses = course::all();
        $course_multiple_sections = array();
        $index = 0;
        $array_dates = $this->getDatesBetween(strtotime($start_date), strtotime($end_date), $vacation_dates);
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
                $time_slot = time_slot::where('id', '=', $courseSections[0]->time_slot_id)->get();
                $st_end_dates = $this->checkIfDateMatchSlotDay([$array_dates[0], $array_dates[count($array_dates) - 1]], $time_slot[0]->day);
                $exam_date = $this->checkAvailableStartAndEndDates($st_end_dates, $course, $sectionsCount);
                if($exam_date == null){
                    $array_dates_new = $this->checkIfDateMatchSlotDay($array_dates, $time_slot[0]->day);
                    $exam_date = $this->getSuitableExamDate(0, count($array_dates_new), $array_dates_new, $course, 0, 0);
                    if($exam_date == null){
                        $exam_date = $this->getSuitableExamDate(0, count($array_dates_new), $array_dates_new, $course, 0, 0, 0);
                    }
                }
                $schedule_maker->exam_date = $exam_date;
                $schedule_maker->save();
            }else{
                $course_multiple_sections[$index++] = $course;
            }
        }
        $value = 0;
        foreach($course_multiple_sections as $course){
            $courseSections = course_appointment::where("course_id", '=', $course->id)->get();
            $exam_date = $this->checkAvailableStartAndEndDates([$array_dates[0], $array_dates[count($array_dates) - 1]], $course, $sectionsCount);
            if($exam_date == null){
                $exam_date = $this->getSuitableExamDate(0, count($array_dates), $array_dates, $course, 0, !$value);
                if($exam_date == null) {
                    $exam_date = $this->getSuitableExamDate(0, count($array_dates), $array_dates, $course, 0, !$value, 0);
                }
            }
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
        return $array_dates;
    }

    private function checkAvailableStartAndEndDates($start_end_dates, $course, $number_of_sections){
        foreach($start_end_dates as $date){
            $courses_in_this_date = $this->getCoursesSpecificDate($date);
            $dist = $this->getMinDistance($course, $courses_in_this_date);
            if($dist > 1){
                if($number_of_sections != 0){
                    $ava_rooms = $this->getNumberOfRoomsAvailable($date);
                    if($ava_rooms >= $number_of_sections){
                        return $date;
                    }
                }else{
                    return $date;
                }
            }
        }
        return null;
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

    private function getSuitableExamDate($low, $high, $array_dates, $course, $number_of_sections, $value, $distance=1){
        if($low > $high){
            return null;
        }
        $mid = floor(($low + $high) / 2);
        if($mid >= count($array_dates)){
            return null;
        }
        $curr_date = $array_dates[$mid];
        $courses_in_this_date = $this->getCoursesSpecificDate($curr_date);
        $dist = $this->getMinDistance($course, $courses_in_this_date);
        if($dist >= $distance){
            if($number_of_sections != 0){
                $ava_rooms = $this->getNumberOfRoomsAvailable($curr_date);
                if($ava_rooms >= $number_of_sections){
                    return $curr_date;
                }
            }else{
                return $curr_date;
            }
        }
        $value = !$value;
        $upper_date = $this->getSuitableExamDate($mid+1, $high, $array_dates, $course, $number_of_sections, $value, $distance);
        $bottom_date = $this->getSuitableExamDate($low, $mid-1, $array_dates, $course, $number_of_sections, $value, $distance);
        if($value){
            if($upper_date != null){
                return $upper_date;
            }else{
                return $bottom_date;
            }
        }else{
            if($bottom_date != null){
                return $bottom_date;
            }else{
                return $upper_date;
            }
        }
    }

    private function getDatesBetween($start_date, $end_date, $vacation_dates=[]){
        $array_dates = array();
        $index = 0;
        for($i = $start_date; $i <= $end_date; $i = $i + 86400){
            if(date('w', $i) == 5 || date('w', $i) == 6) {
                continue;
            }
            if(in_array(date("Y-m-d", $i), $vacation_dates)){
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

    private function checkIfDayIsSun($date){
        $day_num = date('w', strtotime($date));
        if($day_num == 5 || $day_num == 6){
            return true;
        }
        return in_array($day_num, $this::$sun_days_array);
    }

    private function checkIfDateMatchSlotDay($dates, $slot_day){
        $array_dates_new = array();
        $i = 0;
        foreach($dates as $date){
            $is_sun = $this->checkIfDayIsSun($date);
            if($slot_day == 'mon'){
                if(!$is_sun){
                    $array_dates_new[$i++] = $date;
                }
            }else{
                if($is_sun){
                    $array_dates_new[$i++] = $date;
                }
            }
        }
        return $array_dates_new;
    }
    private function getScheduleForSpecificDate($curr_date, $array_dates=null, $next=false, $end_date=null){
        if($array_dates != null){
            $index = array_search($curr_date, $array_dates);
            if($next == "true" && $index < count($array_dates) - 1){
                $curr_date = $array_dates[$index + 1];
            }elseif($next == "false" && $index > 0){
                $curr_date = $array_dates[$index - 1];
            }
        }
        $is_sun = $this->checkIfDayIsSun($curr_date);
        $day_type = $is_sun ? 'sat' : 'mon';
        $brk_type = $is_sun ? $this::$break_time_sun : $this::$break_time_mon;
        $time_slots = time_slot::select(DB::raw("CONCAT(`from`, '-',`to`) AS time_slot, `id`"))->where('day', '=', $day_type)->orWhere('day', '=', $brk_type)->orderBy('time_slot')->get();
        $rooms_info = array();
        $rooms = room::all();
        if($array_dates == null){
            if($end_date == null){
                $end_date = strtotime(date("Y-m-d", strtotime($curr_date)) . " +1 month");
            }else{
                $end_date = strtotime($end_date);
            }
            $array_dates = $this->getDatesBetween(strtotime($curr_date), $end_date);
            $curr_date = $array_dates[0];
        }
        foreach($rooms as $rm){
            $rooms_info[$rm->number] = DB::table('schedule_maker')->select(['time_slot_id', 'exam_date', 'course.name', 'room.id AS room_id', 'schedule_maker.id'])
                ->join('course', 'schedule_maker.course_id', '=', 'course.id')
                ->join('room', 'schedule_maker.room_id', '=', 'room.id')
                ->join('time_slot', 'schedule_maker.time_slot_id', '=', 'time_slot.id')
                ->where('exam_date', $curr_date)->where('room_id', '=', $rm->id)->get();
        }
        // Get all courses.
        $courses = course::all();
        $majors = major::all();
       return compact('array_dates', 'curr_date', 'time_slots', 'rooms_info', 'courses', 'majors', 'rooms');
    }

    function debug_to_console( $data ) {
        $output = $data;
        if ( is_array( $output ) )
            $output = implode( ',', $output);

        echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
    }

    /*
    ####################
    # Routes functions #
    ####################
    */

    public function delete(Request $request){
        $item = schedule_maker::find($request->schedule_id);
        $item->delete();
        $array_dates = explode('|', $request->array_dates);
        return view('Inputs.schedule_maker', $this->getScheduleForSpecificDate($request->exam_date, $array_dates));
    }
    public function search(Request $request){
        $major_id = $request->major_id;
        $room_id = $request->room_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        if($major_id != 9999){
            $courses_id = course::select('id')->where('major_id', '=', $major_id)->get();
        }else{
            $courses_id = course::select('id')->get();
        }
        if($room_id != 9999){
            $rooms_id = [$room_id];
        }else{
            $rooms_id = room::select('id')->get();
        }
        $searchData = DB::table('schedule_maker')
            ->select([DB::raw("CONCAT(time_slot.from, ':', time_slot.to) AS time_slot"), 'exam_date', 'course.name AS course_name', 'room.number AS room_number', 'major.name AS major_name'])
            ->join('course', 'schedule_maker.course_id', '=', 'course.id')
            ->join('room', 'schedule_maker.room_id', '=', 'room.id')
            ->join('time_slot', 'schedule_maker.time_slot_id', '=', 'time_slot.id')
            ->join('major', 'course.major_id', '=', 'major.id')
            ->whereBetween('exam_date', [$start_date, $end_date])
            ->whereIn('course_id', $courses_id)
            ->whereIn('room_id', $rooms_id)->orderBy('exam_date')->orderBy('time_slot')
            ->get();
        return view('partials.search_table', compact('searchData'));
    }

    public function show() {
        /*$time_slots = time_slot::select(DB::raw("CONCAT(`from`, '-',`to`) AS time_slot, `id`"))->where('day', '=', 'sat')->orWhere('day', '=', $this::$break_time_sun)->orderBy('time_slot')->get();
        $rooms_info = array();
        $rooms = room::all();
        //$array_dates = $this->getDatesBetween(strtotime($request->start_date), strtotime($request->end_date));
        foreach($rooms as $rm){
            //foreach($array_dates as $date){
                $rooms_info[$rm->number] = schedule_maker::select(['time_slot_id', 'exam_date'])->whereBetween('exam_date', ['2019-04-05', '2019-05-05'])->where('room_id', '=', $rm->id)->get();
            //}
        }
        //return $rooms_info;*/
       return view('Inputs.schedule_maker', $this->getScheduleForSpecificDate(date('Y-m-d')));
    }

    public function showAJAX(Request $request){
        $array_dates = explode('|', $request->array_dates);
        //return $request->next;
        return view('partials.schedule_table', $this->getScheduleForSpecificDate($request->curr_date, $array_dates, $request->next));
    }

    public function generate(Request $request){
        /*
        Steps to generate:
        1- take the course info.
        2- check if it has more than one section.
        3- if it has more than one, then check the avaliability for rooms.
        4- if there is enough
        */
        // Get all courses.
        //$courses = course::all();
        if($request->remove_schedule == 1){
            DB::table('schedule_maker')->whereBetween('exam_date', [$request->start_date, $request->end_date])->delete();
        }
        $vacation_dates = array();
        if($request->vacation_dates != null && trim($request->vacation_dates) != ''){
            $vacation_dates = explode(',', trim($request->vacation_dates));
        }
        if($request->submit_show != null){
            $array_dates = $this->getDatesBetween(strtotime($request->start_date), strtotime($request->end_date), $vacation_dates);
        }else{
            $array_dates = $this->getCoursesMultipleSections($request->start_date, $request->end_date, $vacation_dates);
        }
        return view('Inputs.schedule_maker', $this->getScheduleForSpecificDate($array_dates[0], $array_dates, false, $array_dates[count($array_dates) - 1]));
        /*$data = DB::table('schedule_maker')
                    ->join('course', 'schedule_maker.course_id', '=', 'course.id')
                    ->join('room', 'schedule_maker.room_id', '=', 'room.id')
                    ->join('time_slot', 'schedule_maker.time_slot_id', '=', 'time_slot.id')
                    ->orderBy('room.id')
                    ->get();
        //return $data;
        $time_slots = time_slot::select(DB::raw("CONCAT(`from`, '-',`to`) AS time_slot, `id`"))->where('day', '=', $this::$break_time_mon)->orWhere('day', '=', 'mon')->get();
        print($time_slots);
        $rooms = room::all();
        $rooms_info = array();
        $array_dates = $this->getDatesBetween(strtotime($request->start_date), strtotime($request->end_date));
        foreach($rooms as $rm){
            //foreach($array_dates as $date){
                $rooms_info[$rm->number] = schedule_maker::select(['time_slot_id', 'exam_date'])->whereBetween('exam_date', [$request->start_date, $request->end_date])->where('room_id', '=', $rm->id)->get();
            //}
        }

        return $rooms_info;
        //return redirect()->back()->with('success', $data);
        //return $data;
        */
    }

    public function insert(Request $request){
        if($request->course_id != 9999) {
            $schedule_maker = new schedule_maker();
            $schedule_maker->course_id = $request->course_id;
            $schedule_maker->exam_date = $request->exam_date;
            $room_id = room::where('number', '=', $request->room_id)->get();
            $schedule_maker->room_id = $room_id[0]->id;
            $schedule_maker->time_slot_id = $request->time_slot_id;
            $schedule_maker->save();
        }
        $array_dates = explode('|', $request->array_dates);
        //return $request->next;
        return view('Inputs.schedule_maker', $this->getScheduleForSpecificDate($request->exam_date, $array_dates));
    }
}
