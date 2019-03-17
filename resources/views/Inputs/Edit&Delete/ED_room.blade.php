@extends('layouts.admin')
@section('content')
    <!-- start: page -->
    <div class="row">
        <div class="col-xs-12">
            <section class="panel">
                <header class="panel-heading">


                    <h2 class="panel-title">Edit & Delete Room</h2>
                </header>
                <div class="panel-body">
                    <form class="form-horizontal form-bordered"  method="post" action="{{url('addNewRoom')}}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="col-md-3 control-label">Select Room :</label>
                            <div class="col-md-6">
                                <select class="form-control" name="room_id" id="room_id" required>
                                    <option selected disabled="" > -- Select Room Number --</option>
                                    @foreach($room as $item)
                                        <option value="{{$item->id}}" data-number="{{$item->number}}" data-college="{{$item->college}}"  data-floor="{{$item->floor}}" > {{$item->number}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Room Number :</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="enter room number" name="number" id="number" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">College Name :</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="college" id="college" placeholder="enter college name" required>
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Floor Number :</label>
                            <div class="col-md-6">
                                <select class="form-control" name="floor" id="floor" required>
                                    <option selected disabled value="100"> -- Select Floor Number --</option>
                                    <option value="-2">-2</option>
                                    <option value="-1">-1</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-lg-7 text-center pull-right"style="margin-top: 15px">
                                <input  name="delete" id="delete" class="btn btn-danger " value="Delete Room" />
                                <input  name="edit" id="edit" class="btn btn-primary " value="Edit Room" />

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
        $("#room_id").on("change",function (event) {
            var ele = event.target;
            var college  = $('option:selected', this).attr('data-college');
            var number     = $('option:selected', this).attr('data-number');
            var floor     = $('option:selected', this).attr('data-floor');
            $("#number").val(number);
            $("#college").val(college);
            $("#floor option[value="+ floor +"]").attr('selected', 'selected');


        });

        $("#delete").on("click",function (event) {
            var id = $("#room_id").val();

            $.ajax({
                type: 'get',
                url: '{!!URL::to('deletroom')!!}',
                data: {
                    'id':id
                },
                success: function(data) {
                    alert("Room Information Deleted Successfully!")
                    $('option:selected', $("#room_id")).remove();
                    $("#number").val("");
                    $("#college").val("");
                    $("#floor").val("100");
                },
                error:function (data) {
                    console.log('error')
                }
            });

        });

        $("#edit").on("click",function (event) {
            var id = $("#room_id").val();
            var number  = $("#number").val();
            var college     = $("#college").val();
            var floor     = $("#floor").val();

            $.ajax({
                type: 'get',
                url: '{!!URL::to('editroom')!!}',
                data: {
                    'id':id,'college':college,'number':number,'floor':floor
                },
                success: function(data) {
                    console.log($('option:selected', $("#room_id")).text(number)) ;
                    alert("Room Information Updated Successfully!")
                },
                error:function (data) {
                    console.log('error')
                }
            });

        });
    })
</script>