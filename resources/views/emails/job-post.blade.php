@extends('emails.layout')
@section('title')
		<title> Translation Job </title>
@endsection
@section('content')
    <h1 style="font-size: 25px; color: #212529; font-weight: 500; margin: 0; padding: 20px 0;"> Translation Job </h1>
    <div class="course" style="padding-bottom: 25px;">
        <table style="width: 100%;  max-width: 70%;  margin-bottom: 1rem;  margin: 0 auto; text-align: left;">
            <tbody>
				<tr style=" font-size: 14px; color: #353535;">
                    <td colspan="2" style="text-align: center;">
                        we have a translation task for you. If you are interested please login and check detail.
						<b><a href="{{ route('teachers.job.list') }}">Click here to view the job</a></b>
                    </td>
                </tr>
                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Student Name</b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px">
                        {{ ucfirst($data['student_firstname'])." ".ucfirst($data['student_lastname']) }}
                    </td>
                </tr>
                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Title</b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px">
                        {{ $data['job_title'] }}
                    </td>
                </tr>
                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Text to translate</b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ $data['job_description'] }}</td>
                </tr>
                <tr style=" font-size: 14px; color: #353535;">
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Price</b></td>
                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ $data['price'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
