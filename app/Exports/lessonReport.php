<?php

namespace App\Exports;

use App\Models\StudentLessonsBooking;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class lessonReport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $bookings = StudentLessonsBooking::
        select(
            DB::raw("row_number() over (ORDER BY student_lessons_bookings.id) as Sr_no"),
            DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS student_name"),
            DB::raw("CONCAT(teachers.firstname, ' ', teachers.lastname) AS teacher_name"),
            'services.title as service',
            'services.price as service_price',
            'location.title as location',
            'lession_date',
            'lession_time',
            'lesson_duration',
            'lession_type',
            'location_detail'
            )
            ->join('users','users.id','student_lessons_bookings.user_id')
            ->join('users as teachers','teachers.id','student_lessons_bookings.teacher_id')
            ->join('services','services.id','student_lessons_bookings.service_id')
            ->join('location','student_lessons_bookings.location_id','location.id')
            ->get();

        return $bookings;
    }

    public function headings(): array
    {
        return [
            'Sr .No',
            ' Students ',
            ' Teachers ',
            ' Services ',
            ' Service Price',
            ' Locations ',
            ' Lesson Booking Date ',
            ' Lesson Booking Time ',
            ' Lesson Duration ',
            ' Lesson Type ',
            ' Location Detail '
        ];
    }
}

