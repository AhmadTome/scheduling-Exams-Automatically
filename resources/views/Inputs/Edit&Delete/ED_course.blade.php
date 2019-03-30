@extends('layouts.admin')
@section('content')
    <!-- start: page -->
    <div class="row">
        <div class="col-xs-12">
            <section class="panel">
                <header class="panel-heading">


                    <h2 class="panel-title">Edit & Delete Course</h2>
                </header>
                <div class="panel-body">
                    <form class="form-horizontal form-bordered"  method="post" action="{{url('addNewCourse')}}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-3 control-label">Select Course :</label>
                            <div class="col-md-6">
                                <select class="form-control" name="course_id" id="course_id" required>
                                    <option selected disabled="" value="100"> -- Select Course Name --</option>
                                    @foreach($course as $item)
                                        <option value="{{$item->id}}" data-serialnum="{{$item->serialnum}}" data-name="{{$item->name}}"
                                                data-academic_year="{{$item->academic_year}}" data-major=" {!! $item->getMajorName($item->major_id) !!}" data-majorID="{{ $item->major_id }}"> {{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Course Serial Number :</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="enter course serial number" name="serialnum" id="serialnum" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Course Name :</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" id="name" placeholder="enter course name" required>
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Academic Year Number :</label>

                            <div class="col-md-6">
                                <select class="form-control" name="academic_year" id="academic_year" required>
                                    <option selected disabled="" value="100"> -- Select Academic Year Number --</option>
                                    <option value="11">1.1</option>
                                    <option value="12">1.2</option>
                                    <option value="21">2.1</option>
                                    <option value="22">2.2</option>
                                    <option value="31">3.1</option>
                                    <option value="32">3.2</option>
                                    <option value="41">4.1</option>
                                    <option value="42">4.2</option>
                                    <option value="51">5.1</option>
                                    <option value="52">5.2</option>
                                </select>                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Major Name :</label>
                            <div class="col-md-6">
                                <select class="form-control" name="major_id" id="major_id" required>
                                    <option selected disabled="" value="100"> -- Select Major Name --</option>
                                    @foreach($major as $item)
                                        <option value="{{$item->id}}" > {{$item->name}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-lg-7 text-center pull-right"style="margin-top: 15px">
                                <input  name="delete" id="delete" class="btn btn-danger " value="Delete Course" />
                                <input  name="edit" id="edit" class="btn btn-primary " value="Edit Course" />

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
        $("#course_id").on("change",function (event) {
            var ele = event.target;
            var serialnum  = $('option:selected', this).attr('data-serialnum');
            var name     = $('option:selected', this).attr('data-name');
            var academic_year     = $('option:selected', this).attr('data-academic_year');
            var major     = $('option:selected', this).attr('data-major');
            var majorID     = $('option:selected', this).attr('data-majorID');

            $("#serialnum").val(serialnum);
            $("#name").val(name);

            $("#academic_year option[value="+ academic_year +"]").attr('selected', 'selected');
            $("#major_id option[value="+ majorID +"]").attr('selected', 'selected');

        });

        $("#delete").on("click",function (event) {
            var id = $("#course_id").val();

            $.ajax({
                type: 'get',
                url: '{!!URL::to('deletcourse')!!}',
                data: {
                    'id':id
                },
                success: function(data) {
                    alert("Course Information Deleted Successfully!")
                    $('option:selected', $("#course_id")).remove();
                    $("#serialnum").val("");
                    $("#name").val("");
                    $("#academic_year").val("100");
                    $("#major_id").val("100");
                },
                error:function (data) {
                    console.log('error')
                }
            });

        });

        $("#edit").on("click",function (event) {
            var id = $("#course_id").val();
            var serialnum  = $("#serialnum").val();
            var name     = $("#name").val();
            var academic_year     = $("#academic_year").val();
            var major_id     = $("#major_id").val();

            $.ajax({
                type: 'get',
                url: '{!!URL::to('editcourse')!!}',
                data: {
                    'id':id,'serialnum':serialnum,'name':name,'academic_year':academic_year,'major_id':major_id
                },
                success: function(data) {
                    console.log($('option:selected', $("#course_id")).text(name)) ;
                    alert("Course Information Updated Successfully!")
                },
                error:function (data) {
                    console.log('error')
                }
            });

        });
    })
</script>