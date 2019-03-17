@extends('layouts.admin')
@section('content')
    <!-- start: page -->
    <div class="row">
        <div class="col-xs-12">
            <section class="panel">
                <header class="panel-heading">


                    <h2 class="panel-title">Add New Room</h2>
                </header>
                <div class="panel-body">
                    <form class="form-horizontal form-bordered"  method="post" action="{{url('addNewRoom')}}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-3 control-label">Room Number :</label>
                            <div class="col-md-6">
                               <input type="text" class="form-control" placeholder="enter room number" name="number" id="number" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">College Name :</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="college" id="college" placeholder="enter college name" value="Engineering & Technology" required>
                                </div>

                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Floor Number :</label>
                            <div class="col-md-6">
                                <select class="form-control" name="floor" id="floor" required>
                                    <option selected disabled="" > -- Select Floor Number --</option>
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
                                <input type="submit"  name="submit" id="submit" class="btn btn-success " value="Add New Room" />
                            </div>

                        </div>

                    </form>
                </div>
            </section>
        </div>
    </div>
@endsection