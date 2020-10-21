{!! Form::open(array('route' => 'students.profile.share.lesson_record','id'=>'share_record','method'=>'POST','autocomplete' => "off","enctype"=>"multipart/form-data")) !!}
    <div class="row">
        <div class="col-12">
            <div class="plan_header">
                <h2>{{__('labels.stu_share_record')}} </h2>
                <p>{{__('labels.stu_type_email_share_record')}}</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-12 col-12">
            <div class="form-group">
                <label>{{__('labels.stu_email')}}</label>
                @if($emails->isEmpty())
                    <input type="email" name="email[0]" value="" id="email-0" class="form-control val-email"  placeholder="{{__('labels.stu_write_email_to_friend')}}">
                @endif
            </div>
        </div>
        <div class="form-group add-option col-md-6">
            <div class="empty-lable">
                <button type="button" class="btn_sub" onclick="optionAction.addOption()">
                    <i class="fas fa-plus" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="email-container">
        @if(!($emails->isEmpty()))
            @include('students.onepage.index.onepage.email.multiple_email')
        @endif
    </div>

    <div class="row">
        <div class="col-12 text-right mt-3">
            <button class="btn_sub btnsub_arr">{{__('labels.btn_share')}}</button>
        </div>
    </div>

    <input type="hidden" name="share_type" value="onepage">

{!! Form::close() !!}

<script>
    <?php
        $lastID = 0;
        if(isset($emails) && (!($emails->isEmpty()))){
            $total = count($emails);
            $lastID = $emails[$total - 1]['id'];
        }
    ?>

    optionAction = {
                inx : {{ (isset($emails)) ? ($lastID+1) : 1 }},
                mchtml : <?= json_encode(View::make('students.onepage.index.onepage.email.form')->render()) ?>,
                addOption : function(){
                    var type = $('#question_type').val();

                    $('#email-container').append(this.mchtml.replace(/{inx}/g, this.inx));
                    this.inx++;

                    $('.val-email').each(function () {
                        $(this).rules("add", {
                            pattern : /^\b[a-z0-9._]+@[a-z_]+?\.[a-z]{2,3}\b$/i,
                            messages: {
                                pattern: "{{__('labels.stu_enter_valid_email')}}"
                            }
                        });
                    });
                },
                removeOption : function(dis){
                    var i = $(dis).data('id');
                    $('#email-'+i).remove();
                    //this.inx--;
                }
            }

   /* $('#share_lesson_record').validate({
        ignore: "",
        rules: {
            'email[]': {
                pattern : /^\b[a-z0-9._]+@[a-z_]+?\.[a-z]{2,3}\b$/i,
            }
        },
        messages: {
            'email[]': {
                pattern: "Please enter valid email gdfg"
            }
        }
    });*/
</script>
