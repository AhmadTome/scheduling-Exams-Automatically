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
                <form class="form-horizontal form-bordered"  method="post" action="{{ url('/scheduleMaker/make') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Start Date :</label>
                        <div class="col-md-6">
                            <input type="date" class="form-control" placeholder="Start Date" name="start_date" id="start_date" value="{{ $date = date('m/d/Y', time()) }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">End Date :</label>

                        <div class="col-md-6">
                            <input type="date" class="form-control" name="end_date" id="end_date" placeholder="End Date" value="{{ $date = date('m/d/Y', time()) }}" required>
                        </div>
                    </div>


                    <div class="form-group ">
                        <div class="col-lg-7 text-center pull-right"style="margin-top: 15px">
                            <input type="submit"  name="submit" id="submit" class="btn btn-success " value="Generate schedule auto." />
                        </div>

                    </div>

                </form>
            </div>
          </section>
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Schedule Maker</h2>
                </header>
                <div class="panel-body">
                    <table class="table">
                        <thead class="thead-dark">
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Room</th>
                            <th scope="col">Sunday</th>
                            <th scope="col">Monday</th>
                            <th scope="col">Tuesday</th>
                            <th scope="col">Wedenesday</th>
                            <th scope="col">Thuresday</th>
                            
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row">1</th>
                            <td>Avaliable</td>
                            <td>Un Avaliable</td>
                            <td>@mdo</td>
                            <td>Avaliable</td>
                            <td>Un Avaliable</td>
                          </tr>
                          <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                            <td>Avaliable</td>
                            <td>Un Avaliable</td>
                          </tr>
                          <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                            <td>Avaliable</td>
                            <td>Un Avaliable</td>
                          </tr>
                        </tbody>
                      </table>
                      @if (session()->has('success'))
                      {!! session()->get('success')->render() !!}
                      @endif
                </div>
            </section>
        </div>
    </div>
@endsection