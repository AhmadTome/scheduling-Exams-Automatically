<section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title">Schedule Maker</h2>
        </header>
        <div class="panel-body">
            <table class="table">
                    <div class="col-md-12">
                            <div class="col-md-3 center ">
                                    <input type="hidden" id="next_prev" name="next" value="false" />
                                    <input type="hidden" id="curr_date_prev" name="curr_date" value="{{ $curr_date }}" />
                                    <input type="hidden" id="array_dates_prev" name="array_dates" value="{{ implode('|',$array_dates) }}" />
                                    <button id="prevBtn" class=" vertical-center btn btn-success">Prev</button>
                            </div>
                        <h3 class="col-md-6 center vertical-center text-primary">{{ $curr_date }} | {{ date('l', strtotime($curr_date)) }}</h3>
                        <div class="col-md-3 center ">
                                        <input type="hidden" id="next_next" name="next" value="true" />
                                        <input type="hidden" id="curr_date_next" name="curr_date" value="{{ $curr_date }}" />
                                        <input type="hidden" id="array_dates_next" name="array_dates" value="{{ implode('|',$array_dates) }}" />
                                        <button id="nextBtn" class=" vertical-center btn btn-success">Next</button>
                                </div>
                    </div>
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Room #</th>
                    @foreach ($time_slots as $slot)
                        <th scope="col">{{ $slot->time_slot }}</th>
                    @endforeach

                  </tr>
                </thead>
                <tbody>
                    @foreach ($rooms_info as $room_number => $rooms_info)
                    <tr>
                        <td>{{ $room_number }}</td>
                        @foreach ($time_slots as $slot)
                            @php
                                $check = false;
                                //$item = '{"time_slot_id":'.$slot->id.',"exam_date":"'.$curr_date.'"}';
                            @endphp
                            @foreach ($rooms_info as $item)
                                @if ($slot->id == $item->time_slot_id && $curr_date == $item->exam_date)
                                    @php
                                        $check = true;
                                        $name = $item->name;
                                        $id = $item->id;
                                        break;
                                    @endphp
                                @endif
                            @endforeach
                            @if ($check)
                                <td class="text-danger unAvailableRoms" id="{{ $room_number.'_'.$slot->time_slot.'_'.$slot->id.'_'.$name.'_'.$id }}">{{ $name }}</td>
                            @else
                                <td class="text-success availableRows" id="{{ $room_number.'_'.$slot->time_slot.'_'.$slot->id }}">Available</td>
                            @endif
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
              </table>
        </div>

        <div class="modal fade" id="modal-7">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Schedule new exam</h4>
                    </div>

                    <div class="modal-body">
                        <form class="form-horizontal form-bordered"  method="post" action="{{ url('/scheduleMaker/insert') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                    <label class="col-md-3 control-label">Exam Date:</label>
                                    <label class="col-md-6 control-label" id="exam_date_lbl">{{ $curr_date }}</label>
                                    <input type="hidden" class="form-control" placeholder="Start Date" name="exam_date" id="exam_date" value="{{ $curr_date }}" required>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Room number:</label>
                                <label class="col-md-6 control-label" id="room_name_lbl"></label>
                                <input type="hidden" class="form-control" placeholder="Start Date" name="room_id" id="room_name_id"  required>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Time slot:</label>
                                <label class="col-md-6 control-label" id="time_slot_lbl">...</label>
                                <input type="hidden" class="form-control" name="time_slot_id" id="time_slot_name_id" placeholder="End Date"/>
                            </div>

                            <div class="form-group">
                                    <label class="col-md-3 control-label">Course Name  :</label>

                                    <div class="col-md-6">
                                        <select class="form-control" name="course_id" id="course_select" required>
                                            <option selected readonly="" value="9999"> -- Select Course Name --</option>
                                            @foreach($courses as $item)
                                                <option value="{{$item->id}}"> {{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                            <div class="form-group ">
                                    <input type="hidden" id="array_dates_insert" name="array_dates" value="{{ implode('|',$array_dates) }}" />
                                    <div class="col-lg-7 text-center pull-right"style="margin-top: 15px">
                                        <input type="submit"  name="submit" id="submit" class="btn btn-success " value="Schedule new exam" />
                                    </div>

                                </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>

    <div class="modal fade" id="modal-show">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Show Exam Data</h4>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal form-bordered"  method="post" action="{{ url('/scheduleMaker/delete') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-3 control-label">Exam Date:</label>
                            <label class="col-md-6 control-label" id="exam_date_lbl">{{ $curr_date }}</label>
                            <input type="hidden" class="form-control" placeholder="Start Date" name="exam_date" id="exam_date" value="{{ $curr_date }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Room number:</label>
                            <label class="col-md-6 control-label" id="show_room_name_lbl"></label>
                            <input type="hidden" class="form-control" placeholder="Start Date" name="room_id" id="show_room_name_id"  required>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Time slot:</label>
                            <label class="col-md-6 control-label" id="show_time_slot_lbl">...</label>
                            <input type="hidden" class="form-control" name="time_slot_id" id="show_time_slot_name_id" placeholder="End Date"/>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Course Name  :</label>

                            <label class="col-md-6 control-label" id="show_course_name_lbl"></label>
                            <input type="hidden" class="form-control" placeholder="Start Date" name="course_id" id="show_course_name_id"  required>

                        </div>

                        <div class="form-group ">
                            <input type="hidden" id="array_dates_insert" name="array_dates" value="{{ implode('|',$array_dates) }}" />
                            <input type="hidden" id="show_schedule_id" name="schedule_id" value="" />
                            <div class="col-lg-7 text-center pull-right"style="margin-top: 15px">
                                <input type="submit"  name="submit" id="submit" class="btn btn-danger " value="Remove exam" />
                            </div>

                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<script>
    $(document).ready(function () {

        $('.availableRows').click(function(e) {
            var txt = $(e.target).text();
            //alert(txt);
            var element_id = e.target.id;

            arr = element_id.split("_");
            $('#room_name_lbl').html(arr[0]);
            $('#time_slot_lbl').html(arr[1]);

            $('#room_name_id').val(arr[0]);
            $('#time_slot_name_id').val(arr[2]);


            $('#modal-7').modal('show', {backdrop: 'static'});
        });

        $('.unAvailableRoms').click(function(e) {
            var txt = $(e.target).text();
            //alert(txt);
            var element_id = e.target.id;
            arr = element_id.split("_");
            console.log(element_id);
            console.log(arr);
            $('#show_room_name_lbl').html(arr[0]);
            $('#show_time_slot_lbl').html(arr[1]);
            $('#show_course_name_lbl').html(arr[3]);


            $('#show_room_name_id').val(arr[0]);
            $('#show_time_slot_name_id').val(arr[2]);
            $('#show_course_name_id').val(arr[3]);
            $('#show_schedule_id').val(arr[4]);



            $('#modal-show').modal('show', {backdrop: 'static'});
        });

        $("#nextBtn").on("click",function () {
            var next = $("#next_next").val();
            var curr_date = $("#curr_date_next").val();
            var array_dates = $("#array_dates_next").val();
            var data = {"next": next, "curr_date":curr_date, "array_dates":array_dates}
            console.log(data)
            $.ajax({
                    type: 'get',
                    url: '{!!URL::to('scheduleMaker/showAJAX')!!}',
                    data: data,
                    success: function(data) {
                        $('#app_table').html(data)
                    },
                    error:function (data) {
                        console.log('error')
                        alert('ERROR!!')
                    }
                });

        })

        $("#prevBtn").on("click",function () {
            var next = $("#next_prev").val();
            var curr_date = $("#curr_date_prev").val();
            var array_dates = $("#array_dates_prev").val();
            var data = {"next": next, "curr_date":curr_date, "array_dates":array_dates}
            console.log(data)
            $.ajax({
                    type: 'get',
                    url: '{!!URL::to('scheduleMaker/showAJAX')!!}',
                    data: data,
                    success: function(data) {
                        $('#app_table').html(data)
                    },
                    error:function (data) {
                        console.log('error')
                        alert('ERROR!!')
                    }
                });

        })
    })
</script>

    </section>


