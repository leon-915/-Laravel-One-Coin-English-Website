<?php
    $sr_no = 1;
    $lesson = $student_lessons;
  
?>
@extends('layouts.app',['title'=>__('labels.stu_previous_cource')])
@section('title', __('labels.stu_previous_cource'))

@section('content')
    <section class="profile_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12 profile_inner tab_pnle_sec">
                    <div class="profile_inner tab_pnle_sec">
                        <div class="row">
                            <div class="col-12">
                                <input type="hidden" id="lesson_id" name="lesson_id" value="{{$lesson['id']}}">
                               {{--  <div class="plan_header">
                                    <h2>Previous Course</h2>
                                </div> --}}
                            </div>
                        </div>
                         <div class="form-group">
                            @php
                                $errs = $errors->all();
                            @endphp
                            @if($errs)
                                @foreach ($errs as $key=>$err)
                                <div class="alert alert-danger" role="alert">
                                    <strong>{{ $err }}</strong>
                                </div>
                                @endforeach
                            @endif

                            @if(Session::has('message'))
                                <div class="alert alert-success" role="alert">
                                    <strong>{{ Session::get('message') }}</strong>
                                </div>
                            @endif
                        </div>
                         <div class="current_course">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="plan_header">
                                            <h2> {{$lesson['service']['title']}}</h2>
                                            <p>{{__('labels.stu_previous_cource_detail')}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="date_time_tbl">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 col-12">
                                            <div class="tym_table_Details">
                                                <h5>{{__('labels.dash_start_date')}}</h5>
                                                <p>{{$lesson['start_date']}}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-12">
                                            <div class="tym_table_Details">
                                                <h5>{{__('labels.dash_end_date')}}</h5>
                                                <p>{{$lesson['expire_date']}}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-12">
                                            <div class="tym_table_Details">
                                                <h5>{{__('labels.dash_cource_terms')}}</h5>
                                                <?php
                                                    $datetime1 = new DateTime($lesson['start_date']);
                                                    $datetime2 = new DateTime($lesson['expire_date']);
                                                    $interval = $datetime1->diff($datetime2);
                                                    $days = $interval->format('%a');
                                                ?>
                                                <p>{{$days}}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-12">
                                            <div class="tym_table_Details">
                                                <h5>{{__('labels.dash_lesson_taught')}}</h5>
                                                <p>{{$completed}}</p>
                                            </div>
                                        </div>
                                    {{--   <div class="col-lg-3 col-md-4 col-12">
                                            <div class="tym_table_Details">
                                                <h5>Rolled Over Lessons</h5>
                                                <p>30</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-12">
                                            <div class="tym_table_Details">
                                                <h5>Avg. Days between (LR)</h5>
                                                <p>30</p>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-md-12">
                                            <div class="table-responsive view_order_list clearfix booking-det">
                                            	<div class="table-inner-container view-order">
                                                <table class="table"  id="previous_course_detail_table">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">{{__('labels.stu_lesson_number')}}</th>
                                                        <th scope="col">{{__('labels.stu_service')}}</th>
                                                        <th scope="col">{{__('labels.stu_location')}}</th>
                                                        <th scope="col">{{__('labels.stu_date')}}</th>
                                                        <th scope="col">{{__('labels.stu_teacher')}}</th>
                                                        <th scope="col">{{__('labels.stu_time')}}</th>
                                                        <th scope="col">{{__('labels.stu_duration')}}</th>
                                                        <th scope="col">{{__('labels.stu_status')}}</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-12 text-right mt-3">
                                            <a href ="/student/dashboard?ref=prev_course" class="btn_custon">{{__('labels.btn_back')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- share record  -->
                        <div class="row">
                            @include('students.dashboard.index.share_record')
                        </div>
                        <!-- share record -->
                    </div>
                </div>
            </div>
            
        </div>
    </section>
    @push('scripts')
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" src="{{ asset('assets/admin/validation/jquery.validate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/admin/validation/additional-methods.min.js') }}"></script>
        <script type="text/javascript">
            var prevDataTable = '';
            var lesson_id = $("#lesson_id").val();
            //alert(lesson_id);

            prevDataTable = $('#previous_course_detail_table').DataTable({
                            dom: "<'row'<'col-sm-12 col-md-9'i><'col-sm-12 col-md-3'l>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-12'p>>",
                            processing: true,
                            serverSide: true,
                            searching: false,
                            language: {
                                'loadingRecords': '&nbsp;',
                                'processing': '<div class="jumping-dots-loader"><span></span><span></span><span></span></div>',
                                "paginate": {
                                    "previous": "<i class='fas fa-chevron-left'></i>",
                                    "next": "<i class='fas fa-chevron-right'></i>",
                                }
                            },
                            ajax: {
                                url: '{{route('students.dashboard.get.previous.detail')}}',
                                type: 'POST',
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                data: function (d) {
                                    d.lesson_id = lesson_id;
                                }
                            },
                            order: [[0, 'DESC']],
                            columns: [
                                {data: 'DT_RowIndex', name: 'DT_RowIndex','orderable':false,'searchable':false},
                                {data: 'service', name: 'service'},
                                {data: 'location', name: 'location', orderable: false, searchable: false},
                                {data: 'date', name: 'date'},
                                {data: 'teacher', name: 'teacher'},
                                {data: 'time', name: 'time'},
                                {data: 'duration', name: 'duration'},
                                {data: 'status', name: 'status'}
                            ],
                             
                        });


            <?php
                $lastID = 0;
                if(isset($emails) && (!($emails->isEmpty()))){
                    $total = count($emails);
                    $lastID = $emails[$total - 1]['id'];
                }
            ?>

        optionAction = {
            inx : {{ (isset($emails)) ? ($lastID+1) : 1 }},
            mchtml : <?= json_encode(View::make('students.dashboard.index.email.form')->render()) ?>,
            addOption : function(){
                var type = $('#question_type').val();
                
                $('#email-container').append(this.mchtml.replace(/{inx}/g, this.inx));
                $('#title-'+this.inx).rules("add", {
                    pattern : /^\b[a-z0-9._]+@[a-z_]+?\.[a-z]{2,3}\b$/i,
                    required: true,
                    messages: {
                        pattern: "{{__('jsValidate.required.valid_email')}}",
                        required: "{{__('jsValidate.required.email')}}"
                    }
                });
                this.inx++;

                
            },
            removeOption : function(dis){
                var i = $(dis).data('id');
                $('#email-'+i).remove();
                //this.inx--;
            }
        }

        $("#frm_share_record").validate()

        $(document).ready(function() {
            $('input[data-email]').each(function (index, value) {
                var id=$(value).attr('id');
                console.log($("input#"+id));
                console.log(value);
              /*  $("input#"+id)[0].rules( "remove" );
                $('input#'+id)[0].rules("add", {
                    pattern : /^\b[a-z0-9._]+@[a-z_]+?\.[a-z]{2,3}\b$/i,
                    messages: {
                        pattern: "Enter valid email"
                    }
                });*/
                $(value).rules( "remove" );
                $(value).rules("add", {
                    pattern : /^\b[a-z0-9._]+@[a-z_]+?\.[a-z]{2,3}\b$/i,
                    required: true,
                    messages: {
                        pattern: "{{__('jsValidate.required.valid_email')}}",
                        required: "{{__('jsValidate.required.email')}}"
                    }
                });
            });
        })
        
        </script>
    @endpush
@endsection




                     