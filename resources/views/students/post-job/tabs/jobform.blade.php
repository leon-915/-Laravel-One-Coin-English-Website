<div class="current_course">
    <div class="row">
            {!! Form::open(array('route' => 'students.post.job.create','method'=>'POST','id'=>'create_job','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}

            <div class="col-12">
                <div class="plan_header">
                    <h2>{{__('labels.stu_post_new_job')}}</h2>
                    <p>{{__('labels.stu_some_detail_job_post')}}</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="form-group full">
                    <label>{{__('labels.stu_subject')}}<span class="astric">*</span></label>
                    {!! Form::text('subject', null, array('placeholder' => 'Write job subject','class'=> 'form-control','id' => 'subject'))!!}
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="form-group full">
                    <label>{{__('labels.stu_price')}}<span class="astric">*</span></label>
                    {!! Form::text('price', null, array('placeholder' => 'Write job price','class'=> 'form-control','id' => 'price'))!!}
                </div>
            </div>
            <div class="col-lg-12 col-md-6 col-12">
                <div class="form-group full">
                    <label>{{__('labels.stu_translate_text')}}<span class="astric">*</span></label>
                    {!! Form::textarea('description', null, ['rows'=>4,'cols'=>50])!!}
                </div>
            </div>
            <div class="col-lg-12 col-md-6 col-12">
                <div class="new_job_btn add_new">
                    {!! Form::submit('Add Job', ['class' => 'btnsub_arr', 'id'=>"submit_btn"]) !!}
                    <a href="{{route('students.post.job.index')}}" class="btnsub_arr">{{__('labels.btn_cancel')}}</a>
                </div>
            </div>

            {!! Form::close() !!}

    </div>
</div>

@push('scripts')
    <script type="text/javascript" src="{{ asset('assets/admin/validation/jquery.validate.min.js') }}"></script>
    <script>
        $('#create_job').validate({
            ignore: "",
            rules: {
                subject: {
                    required: true
                },
                price: {
                    required: true,
                    number: true
                },
                description: {
                    required: true
                }
            },
            messages: {
                subject: {
                    required: "{{__('jsValidate.required.add_subject')}}",
                },
                price: {
                    required:  "{{__('jsValidate.required.price')}}",
                    number:  "{{__('jsValidate.required.number')}}",
                },
                description: {
                    required:  "{{__('jsValidate.required.description')}}",
                }
            }
        })

    </script>
@endpush
