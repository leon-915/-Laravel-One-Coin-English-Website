@extends('emails.layout')
@section('title')
		<title> Lesson Wrapped </title>
@endsection
@section('content')
    <h1 style="font-size: 25px; color: #212529; font-weight: 500; margin: 0; padding: 20px 0;"> Lesson Wrapped </h1>
    <div class="course" style="padding-bottom: 25px;">
        <table style="width: 100%;  max-width: 70%;  margin-bottom: 1rem;  margin: 0 auto; text-align: left;">
            <tbody>
                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Dear Parent/Guardian,</b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px">
                        Please use your student's login detail to login and view wrapped session detail.
                    </td>
                </tr>
				<tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Student Name</b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px">
                        {{ ucfirst($data['student']['firstname'])." ".ucfirst($data['student']['lastname']) }}
                    </td>
                </tr>
                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Teacher Name</b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px">
                        {{ $data['teacher']['firstname']." ". $data['teacher']['lastname'] }}
                    </td>
                </tr>
                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Lesson Date</b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ $data['date'] }}</td>
                </tr>
                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Lesson Time</b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ $data['time'] }}</td>
                </tr>
                <tr style=" font-size: 14px; color: #353535;">
                    <td style="text-align: center;">
                       <b><a href="{{ route('students.share.onepage.index', ['id' => encrypt($data['booking']['id'])]) }}">Click Here to View Onepage</a></b>
                    </td>
					<td style="text-align: center;">
                       Alternatively you can download session detail pdf <a href="{{ route('students.onepage.generate.pdf', ['booking_id' => $data['booking']['id']]) }}">here</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
