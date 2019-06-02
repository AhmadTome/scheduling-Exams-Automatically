<!DOCTYPE HTML>
<html dir="rtl">
<head>
    <title>
        @yield('title')
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/ico" href="{{ asset('img/photo2.png') }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .printDoc {
            width: 210mm;
        }
        .text-center {
            text-align: center;
        }
        .left-header {
            float: left;
            width: 35%;
        }
        .middle-header {
            float: left;
            width: 30%;
        }
        .right-header {
            float: right;
            width: 35%;
        }
        .footer {
            border-top: 2px solid black;
            border-bottom: 1px solid black;
        }
        .header {
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .table tr td {
            text-align: center;
        }
        .border-1 {
            border: 1px solid black;
        }
        .border-2 {
            border: 2px solid black;
        }
        .padding {
            padding: 10px;
        }
        .black-header thead {
            background-color: lightgray;
        }
        .content {
            margin: 30px;
        }
        th, td {
            text-align: center;
        }
        .gray-back {
            background-color: lightgray;
        }
        .half-width {
            width: 50% !important;
        }
        .cols-2 th {
            width: 30%;
        }
        .cols-2 td {
            width: 70%;
        }
        .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
            border: 1px solid black;
        }
        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
            padding: 1px !important;
        }
        .box {
            display: block;
            border: 1px solid black;
            width: 100%;
            height: 150px;
            margin-top: 0px;
        }
        html {
            font-size: 12pt !important;
        }
        .margin-0 {
            margin: 0px;
        }
        .padding-0 {
            padding: 0px;
        }
        .show-print {
            display: none;
        }
        @page {
            size: A4;
            margin: 11mm 17mm 17mm 17mm;
        }
        @media print {
            @page { margin: 0; }
            body { margin: 1.6cm; }


            html, body {
                width: 210mm;
                height: 297mm;
            }
            .show-print {
                display: block !important;
            }
            .hide-print {
                display: none;
            }
            .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                padding: 1px !important;
            }
            .dont-print {
                display: none;
            }
            .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
                border: 1px solid black;
            }
            .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                padding: 4px !important;
            }
            .table-0 > tbody > tr > td, .table-0 > tbody > tr > th, .table-0 > tfoot > tr > td, .table-0 > tfoot > tr > th, .table-0 > thead > tr > td, .table-0 > thead > tr > th {
                padding: 0px !important;
            }
            .gray-back {
                background-color: lightgray;
            }
        }
        #discount {
            width: 100px;
        }
        #discount input {
            width: 100px;
            border: none;
            text-align: center;
        }
        #discount input:focus {
            border: none;
        }
        #discount input::-webkit-inner-spin-button,
        #discount input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>
<body>
<div class="col-sm-4 col-sm-offset-4">
    <button onclick="window.print()" class="dont-print btn btn-primary btn-block">
        <span class="glyphicon glyphicon-print"></span> Print
    </button>
</div>
<div class="clearfix"></div>
<br>
<div>
    <div class="header">
        <div class="text-center">
            بسم الله الرحمن الرحيم
        </div>
        <div class="clearfix"></div>
        <div>
            <div class="left-header text-center">

                <h4>
                    palestine technical university - kadoorie
                </h4>
                <h5>
                    Tulkarm
                </h5>
            </div>

            <div class="middle-header" align="center" width="50">
                <img src="/img/projectIcon.png" height="150">
            </div>

            <div class="right-header text-center">

                <h4>
                    جامعة فلسطين التقنية - خضوري
                </h4>
                <h5>
                     طولكرم
                </h5>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="content">
        <section class="panel" >

            <div class="panel-body" id="printMe">
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

        </section>    </div>


</div>

</body>
</html>


