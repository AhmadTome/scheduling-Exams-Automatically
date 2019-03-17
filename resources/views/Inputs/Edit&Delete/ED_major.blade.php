@extends('layouts.admin')
@section('content')
    <!-- start: page -->
    <div class="row">
        <div class="col-xs-12">
            <section class="panel">
                <header class="panel-heading">


                    <h2 class="panel-title">Edit & Delete Major</h2>
                </header>
                <div class="panel-body">
                    <form class="form-horizontal form-bordered"  method="post" action="{{url('addNewMajor')}}">
                        {{ csrf_field() }}


                        <div class="form-group">
                            <label class="col-md-3 control-label">Select Major Name :</label>
                            <div class="col-md-6">
                                <select class="form-control" name="major_id" id="major_id" required>
                                    <option selected disabled="" > -- Select Major Name --</option>
                                    @foreach($major as $item)
                                        <option value="{{$item->id}}" data-name="{{$item->name}}" data-college="{{$item->college}}" > {{$item->name}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">Major Name :</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="enter major name" name="name" id="name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">College Name :</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="college" id="college" placeholder="enter college name"  required>
                            </div>
                        </div>


                        <div class="form-group ">
                            <div class="col-lg-7 text-center pull-right"style="margin-top: 15px">
                                <input  name="delete" id="delete" class="btn btn-danger " value="Delete Major" />
                                <input  name="edit" id="edit" class="btn btn-primary " value="Edit Major" />

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
        $("#major_id").on("change",function (event) {
            var ele = event.target;
            var college  = $('option:selected', this).attr('data-college');
            var name     = $('option:selected', this).attr('data-name');
            $("#name").val(name);
            $("#college").val(college);

        });

        $("#delete").on("click",function (event) {
            var id = $("#major_id").val();

            $.ajax({
                type: 'get',
                url: '{!!URL::to('deletmajor')!!}',
                data: {
                    'id':id
                },
                success: function(data) {
                    alert("Major Information Deleted Successfully!")
                    $('option:selected', $("#major_id")).remove();
                    $("#name").val("");
                    $("#college").val("");
                },
                error:function (data) {
                    console.log('error')
                }
            });

        });

        $("#edit").on("click",function (event) {
            var id = $("#major_id").val();
            var name  = $("#name").val();
            var college     = $("#college").val();

            $.ajax({
                type: 'get',
                url: '{!!URL::to('editmajor')!!}',
                data: {
                    'id':id,'college':college,'name':name
                },
                success: function(data) {
                    console.log($('option:selected', $("#major_id")).text(name)) ;
                    alert("Major Information Updated Successfully!")
                },
                error:function (data) {
                    console.log('error')
                }
            });

        });
    })
</script>