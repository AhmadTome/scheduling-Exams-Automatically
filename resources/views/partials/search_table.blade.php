<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">Search schedule table</h2>
    </header>
    <div class="panel-body">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Room #</th>
                <th scope="col">Course Name</th>
                <th scope="col">Major Name</th>
                <th scope="col">Exam Date</th>
                <th scope="col">Time slot</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($searchData as $schedule_data)
                <tr>
                    <td>{{ $schedule_data->room_number }}</td>
                    <td>{{ $schedule_data->course_name }}</td>
                    <td>{{ $schedule_data->major_name }}</td>
                    <td>{{ $schedule_data->exam_date }}</td>
                    <td>{{ $schedule_data->time_slot }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</section>


