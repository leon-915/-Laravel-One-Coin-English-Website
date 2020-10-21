<?php

namespace App\Exports;

use App\Models\StudentLessons;
use App\Models\StudentLessonsBooking;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActiveStudents implements FromCollection , WithHeadings
{

    public function collection()
    {
        $active_student = StudentLessons::
        select(
            DB::raw("row_number() over (ORDER BY student_lessons.id) as Sr_no"),
            'users.email As student_name',
            'users.firstname As first_name',
            'users.lastname As last_name',
            'student_lessons.id As Order_id',
            'services.id as product_id',
            'services.title as product_name',
            'student_lessons.created_at',
            'student_lessons.expire_date',
            //DB::raw("IF student_lessons.status == 1 THEN 'Active' ELSE 'Inactive' END IF"),
            DB::raw("(CASE WHEN student_lessons.status=1 THEN 'Active'
                                ELSE 'Inactive' END) AS status")
        )
            ->join('users','users.id','student_lessons.user_id')
            ->join('services','services.id','student_lessons.service_id')
            ->where('student_lessons.status',1)
            ->get();

        return $active_student;
    }

    public function headings(): array
    {
        return [
            'Sr. No',
            'Students Email',
            'First Name',
            'Last name',
            'Order Id',
            'Product Id',
            'Product Name',
            'Order Date',
            'Expiry Date',
            'Status'
        ];
    }
}
