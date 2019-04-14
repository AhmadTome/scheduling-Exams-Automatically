<?php
use App\Http\Controllers\schedule;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/logout', 'HomeController@logout');
Route::get('/home', 'HomeController@index')->name('home');


// Start Room Router
Route::get('/room', function () {
    return view('Inputs.rooms');
});
Route::get('/ED_room', function () {
    $room = \App\room::all();
    return view('Inputs.Edit&Delete.ED_room')->with('room',$room);
});

Route::get('/deletroom', function (\Illuminate\Http\Request $request) {
    \App\room::where('id',$request->id)->delete();
});
Route::get('/editroom', function (\Illuminate\Http\Request $request) {
    \App\room::where('id','=',$request->id)
        ->update(array("college"=>$request->college,"number"=>$request->number,"floor"=>$request->floor));});
Route::post('addNewRoom','Inputs@addNewRoom');
// End Room Router


// Start Course Router
Route::get('/course', function () {
    $major = \App\major::all();
    return view('Inputs.course')->with('major',$major);
});
Route::get('/ED_course', function () {
    $course = \App\course::all();
    $major = \App\major::all();
    return view('Inputs.Edit&Delete.ED_course')->with('course',$course)->with('major',$major);
});
Route::get('/deletcourse', function (\Illuminate\Http\Request $request) {
    \App\course::where('id',$request->id)->delete();
});
Route::get('/editcourse', function (\Illuminate\Http\Request $request) {
    \App\course::where('id','=',$request->id)
        ->update(array("serialnum"=>$request->serialnum,"name"=>$request->name,
            "major_id"=>$request->major_id,"academic_year"=>$request->academic_year));});

Route::post('addNewCourse','Inputs@addNewCourse');
// End Course Router




// Start Major Router
Route::get('/major', function () {
    return view('Inputs.major');
});
Route::get('/ED_major', function () {
    $major = \App\major::all();
    return view('Inputs.Edit&Delete.ED_major')->with('major',$major);
});

Route::get('/deletmajor', function (\Illuminate\Http\Request $request) {
    \App\major::where('id',$request->id)->delete();
});
Route::get('/editmajor', function (\Illuminate\Http\Request $request) {

    \App\major::where('id','=',$request->id)
        ->update(array("name"=>$request->name,"college"=>$request->college));
});

Route::post('addNewMajor','Inputs@addNewMajor');
// End Major Router


Route::prefix('schedule')->group(function () {

    Route::get('add', function () {
        $course = \App\course::all();
        $room = \App\room::all();
       return view('Inputs.course_schedule')->with('course',$course)->with('room',$room);
    });

    Route::get('GetAvailableTime','schedule@GetAvailableTime');

    Route::post('addCourseToSchedule','schedule@addCourseToSchedule');


});

Route::prefix('scheduleMaker')->group(function () {

    Route::get('show', function () {
       return view('Inputs.schedule_maker');
    });
    Route::post('make', 'scheduleMaker@generateAutomaticSchedule');
     

});