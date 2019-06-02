@extends('layouts.admin')
@section('content')
    <!-- start: page -->
    <div class="row">
        <div class="col-xs-12">
          <section class="panel">
            <header class="panel-heading">
              <h2 class="panel-title">Choose the exam date</h2>
            </header>
            <div class="panel-body">
                <form id="generate_form" class="form-horizontal form-bordered"  method="post" action="{{ url('/scheduleMaker/generate') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-md-2 control-label">Start Date :</label>
                        <div class="col-md-4">
                            <input type="date" class="form-control" placeholder="Start Date" name="start_date" id="start_date" value="{{ date('Y-m-d') }}"  required>
                        </div>
                        <label class="col-md-2 control-label">End Date :</label>

                        <div class="col-md-4">
                            <input type="date" class="form-control" name="end_date" id="end_date" value="{{ date('Y-m-d',strtotime(date('Y-m-d')." +1 month")) }}" placeholder="End Date" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Vacation Date :</label>
                        <div class="col-md-6">
                            <input type="date" class="form-control" name="vacation" id="vacation_date" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-3">
                            <input type="button" class="form-control btn btn-success" name="add_vacation_date" id="add_vacation_date" value="Add vacation date"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Vacation Dates :</label>
                        <div class="col-md-6">
                            <input type="hidden" class="form-control" name="vacation_dates" id="vacation_dates" placeholder="Vacation Dates" value="">
                            <input type="text" class="form-control" name="vacs" id="vacation_dates_show" placeholder="Vacation Dates" value="" disabled>
                        </div>
                        <div class="col-md-3">
                            <input type="button" class="form-control btn btn-warning" name="clear_vacation_date" id="clear_vacation_date" value="Clear dates"/>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-lg-7 text-center pull-right"style="margin-top: 15px">
                            <input type="hidden" name="remove_schedule" id="remove_schedule" value="0" />
                            <input type="submit"  name="submit_show" id="submit_show" class="btn btn-primary " value="Show schedule" />
                            <input type="button"  name="submit_generate" id="submit_generate" class="btn btn-success " value="Generate schedule auto." />
                        </div>

                    </div>

                </form>
            </div>
          </section>

            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Search Form:</h2>
                </header>
                <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Start Date</label>
                            <div class="col-md-4">
                                <input type="date" class="form-control" placeholder="Start Date" name="start_date" id="start_date" value="{{ date('Y-m-d') }}"  required>
                            </div>
                            <label class="col-md-2 control-label">End Date</label>

                            <div class="col-md-4">
                                <input type="date" class="form-control" name="end_date" id="end_date" value="{{ date('Y-m-d',strtotime(date('Y-m-d')." +1 month")) }}" placeholder="End Date" required>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-2 control-label">Rooms</label>
                            <div class="col-md-4">
                            <select class="form-control" name="room_id" id="search_room_id" required>
                                <option selected readonly="" value="9999"> -- Select Room Number --</option>
                                <option value="9999">All</option>
                                @foreach($rooms as $item)
                                    <option value="{{$item->id}}">{{ $item->number }}</option>
                                @endforeach
                            </select>
                            </div>

                            <label class="col-md-2 control-label">Majors</label>
                            <div class="col-md-4">
                                <select class="form-control" name="major_id" id="search_major_id" required>
                                    <option selected readonly="" value="9999"> -- Select Major Name --</option>
                                    <option value="9999">All</option>
                                    @foreach($majors as $item)
                                        <option value="{{$item->id}}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>


                        <div class="form-group ">
                            <div class="col-lg-7 text-center pull-right"style="margin-top: 15px">
                                <input type="submit"  name="submit_search" id="submit_search" class="btn btn-success " value="Search" />
                            </div>

                        </div>

                </div>
            </section>

          <div id="app_table">
          @include('partials.schedule_table')
          </div>
        </div>
    </div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>


<script type="text/javascript">
    $(document).ready(function () {
        $("#submit_generate").on("click", function () {

            Swal.fire({
                title: 'Do you want to generate exams schedule auto.?',
                text: "You won't be able to revert this!",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d00',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: 'Do You want to remove the scheduled exams in this period?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#0d0',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.value) {
                            $("#remove_schedule").val(1);
                            $("#generate_form").submit();
                        }else{
                            $("#remove_schedule").val(0);
                            $("#generate_form").submit();
                        }
                    })
                }
            })
        });
        $("#submit_search").on("click",function () {
            var major_id = $("#search_major_id").val();
            var room_id = $("#search_room_id").val();
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            var data = {"major_id": major_id, "room_id":room_id, "start_date":start_date, "end_date": end_date}
            console.log(data)
            $.ajax({
                type: 'get',
                url: '{!!URL::to('scheduleMaker/search')!!}',
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

        $("#clear_vacation_date").on("click", function () {
            $("#vacation_dates").val("");
            $("#vacation_dates_show").val("");
        })

        $("#add_vacation_date").on("click", function () {
            var vacation_date = $("#vacation_date").val();
            var vacations_val = $("#vacation_dates").val();
            if(vacations_val === ""){
                $("#vacation_dates").val(vacation_date)
                $("#vacation_dates_show").val(vacation_date)
            }else{
                $("#vacation_dates").val(vacations_val + "," + vacation_date)
                $("#vacation_dates_show").val(vacations_val + "," + vacation_date)
            }
        })


    });

</script>

