<?php

namespace App\Http\Controllers;

use App\course;
use App\major;
use App\room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;


class Inputs extends Controller
{
    public function addNewRoom(Request $request){
        $this->validate($request,[
            'floor' => 'required:room,floor',
            'number' => 'required:room,number',
            'college' => 'required:room,college'
        ]);

        $room = new room();
        $room->number = Input::get('number');
        $room->floor = Input::get('floor');
        $room->college = Input::get('college');
        if($room->save()){
            session()->flash("success","Room ". Input::get('number') ." Added Successfully ");
        }else{
            session()->flash("errors","Some thing that be wrong !");
        }
        return redirect()->back();
    }

    public function addNewMajor(Request $request){
        $this->validate($request,[
            'name' => 'required:major,name',
            'college' => 'required:major,college'
        ]);

        $major = new major();
        $major->name = Input::get('name');
        $major->college = Input::get('college');
        if($major->save()){
            session()->flash("success","New Major ". Input::get('name') ." Added Successfully ");
        }else{
            session()->flash("errors","Some thing that be wrong !");
        }
        return redirect()->back();
    }

    public function addNewCourse(Request $request){
        $this->validate($request,[
            'academic_year' => 'required:course,academic_year',
            'major_id' => 'required:course|exists:major,id',
            'serialnum' => 'required:course,serialnum',
            'name' => 'required:course,name'
        ]);

        $course = new course();
        $course->serialnum = Input::get('serialnum');
        $course->name = Input::get('name');
        $course->academic_year = Input::get('academic_year');
        $course->major_id = Input::get('major_id');
        if($course->save()){
            session()->flash("success","Course ". Input::get('name') ." Added Successfully ");
        }else{
            session()->flash("errors","Some thing that be wrong !");
        }
        return redirect()->back();
    }
}
