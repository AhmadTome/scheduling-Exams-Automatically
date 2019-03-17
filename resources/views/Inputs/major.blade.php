@extends('layouts.admin')
@section('content')
    <!-- start: page -->
    <div class="row">
        <div class="col-xs-12">
            <section class="panel">
                <header class="panel-heading">


                    <h2 class="panel-title">Add New Major</h2>
                </header>
                <div class="panel-body">
                    <form class="form-horizontal form-bordered"  method="post" action="{{url('addNewMajor')}}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-3 control-label">Major Name :</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="enter major name" name="name" id="name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">College Name :</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="college" id="college" placeholder="enter college name" value="Engineering & Technology" required>
                            </div>
                        </div>


                        <div class="form-group ">
                            <div class="col-lg-7 text-center pull-right"style="margin-top: 15px">
                                <input type="submit"  name="submit" id="submit" class="btn btn-success " value="Add New Major" />
                            </div>

                        </div>

                    </form>
                </div>
            </section>
        </div>
    </div>
@endsection