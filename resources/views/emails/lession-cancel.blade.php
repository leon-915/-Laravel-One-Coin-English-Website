@extends('emails.layout')
@section('title')
		<title> Lesson Cancelled </title>
@endsection
@section('content')
		<h1 style="font-size: 25px; color: #212529; font-weight: 500; margin: 0; padding: 20px 0;"> Lesson Cancelled </h1>
		<div class="course" style="padding-bottom: 25px;">
				<table style="width: 100%;  max-width: 70%;  margin-bottom: 1rem;  margin: 0 auto; text-align: left;">
						<tbody>
						<tr style=" font-size: 14px; color: #353535;">
								<td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Student Name</b></td>
								<td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ ucfirst($data['student']['firstname'])." ". ucfirst($data['student']['lastname']) }}</td>
                        </tr>
                        <tr style=" font-size: 14px; color: #353535;">
                            <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Teacher Name</b></td>
                            <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ ucfirst($data['teacher']['firstname'])." ". ucfirst($data['teacher']['lastname']) }}</td>
                         </tr>
                         <tr style=" font-size: 14px; color: #353535;">
                                <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Lesson Date</b></td>
                                <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ $data['date'] }}</td>
                         </tr>
                         <tr style=" font-size: 14px; color: #353535;">
                                <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Lesson Time</b></td>
                                <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ $data['time'] }}</td>
                         </tr>
                        @if(isset($data['lesson']) && !empty($data['lesson']))
                             <tr style=" font-size: 14px; color: #353535;">
                                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Lesson</b></td>
                                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ $data['lesson'] }}</td>
                             </tr>
                        @endif
                        @if(isset($data['location']) && !empty($data['location']))
                             <tr style=" font-size: 14px; color: #353535;">
                                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> <b>Location</b></td>
                                    <td style="border-top: 1px solid #dee2e6; padding: 5px"> {{ $data['location'] }}</td>
                             </tr>
                        @endif

					 </tbody>
			 </table>
		</div>

@endsection
