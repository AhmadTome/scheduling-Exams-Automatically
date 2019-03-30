@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <section class="panel">
                <header class="panel-heading">


                    <h2 class="panel-title">Add Courses To Schedule</h2>
                </header>
                <div class="panel-body">
                    <form class="form-horizontal form-bordered"  method="post" action="{{url('schedule/addCourseToSchedule')}}">
                        {{ csrf_field() }}


                        <div class="form-group">
                            <label class="col-md-3 control-label">Course Name  :</label>

                            <div class="col-md-6">
                                <select class="form-control" name="course_select" id="course_select" required>
                                    <option selected readonly="" value="100"> -- Select Course Name --</option>
                                    @foreach($course as $item)
                                        <option value="{{$item->id}}"> {{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Day  :</label>

                            <div class="col-md-6">
                                <select class="form-control" name="Day_select" id="Day_select" required>
                                    <option selected readonly="" value="100"> -- Select Day --</option>
                                    <option value="sat">Saturday - Tuesday - Thursday</option>
                                    <option value="mon">Monday - Wednesday</option>

                                </select>
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Select Room :</label>
                            <div class="col-md-6">
                                <select class="form-control" name="room_id" id="room_id" required>
                                    <option selected readonly="" value="100"> -- Select Room Number --</option>
                                    @foreach($room as $item)
                                        <option value="{{$item->id}}" data-number="{{$item->number}}" data-college="{{$item->college}}"  data-floor="{{$item->floor}}" > {{$item->number}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-lg-7 text-center pull-right"style="margin-top: 15px">
                                <input  name="showTimeSlot" id="showTimeSlot" class="btn btn-primary " value="Select Time Slot" />
                            </div>

                        </div>

                        <div class="form-group" style="display: none" id="time_slot">
                            <label class="col-md-3 control-label">Time Slot  :</label>

                            <div class="col-md-6">
                                <select class="form-control" name="time_slot_select" id="time_slot_select" required>
                                    <option selected disabled="" value="100"> -- Select Time Slot --</option>

                                </select>
                            </div>

                        </div>

                        <div class="form-group ">
                            <div class="col-lg-7 text-center pull-right"style="margin-top: 15px">
                                <input type="submit"  name="submit" id="submit" class="btn btn-success " value="Add Course Section" />
                            </div>

                        </div>

                    </form>
                </div>
            </section>
        </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
    $(document).ready(function () {

        $("#course_select,#room_id,#Day_select").on("change",function () {
            $("#time_slot").hide();
        })

        $("#showTimeSlot").on("click",function () {
            var course = $("#course_select").val();
            var day = $("#Day_select").val();
            var room = $("#room_id").val();

            if(course == "100" || day == "100" || room == "100"){
                alert("Should Select The Correct Inputs")
                return false;
            }else {
                $.ajax({
                    type: 'get',
                    url: '{!!URL::to('schedule/GetAvailableTime')!!}',
                    data: {
                        'course_id':course,'day_id':day,'room_id':room
                    },
                    success: function(data) {
                        data = JSON.parse(data)
                        $("#time_slot_select").empty();
                        for (var i = 0 ; i< data.length ; i++){
                            $("#time_slot_select").append('<option value="'+ data[i].id +'"> '+ data[i].From +" - "+ data[i].To +'</option>');
                        }
                        $("#time_slot").show();
                       // alert("Room Information Updated Successfully!")
                    },
                    error:function (data) {
                        console.log('error')
                    }
                });

            }

        })
    })
</script>