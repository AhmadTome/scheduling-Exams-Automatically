@extends('layouts.admin')
@section('content')
    <!-- start: page -->
    <div class="row">
        <div class="col-xs-12">
            <section class="panel">
                <header class="panel-heading">


                    <h2 class="panel-title">Add New Course</h2>
                </header>
                <div class="panel-body">
                    <form class="form-horizontal form-bordered"  method="post" action="{{url('addNewCourse')}}">
                        {{ csrf_field() }}
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
                                    <option selected disabled="" > -- Select Academic Year Number --</option>
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
                                    <option selected disabled="" > -- Select Major Name --</option>
                                    @foreach($major as $item)
                                        <option value="{{$item->id}}" > {{$item->name}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-lg-7 text-center pull-right"style="margin-top: 15px">
                                <input type="submit"  name="submit" id="submit" class="btn btn-success " value="Add New Course" />
                            </div>

                        </div>

                    </form>
                </div>
            </section>
        </div>
    </div>
@endsection