@extends('layouts.app',['title'=> __('labels.stu_student_reservation')])
@section('title', __('labels.stu_student_reservation'))
@section('content')

    <section class="profile_sec reservation_sec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="profile_inner tab_pnle_sec">

                        {{-- @include('students.reservation.index.top-search') --}}

                        <div class="card custome_nav">
                            <ul class="tabs_li nav nav-tabs one-page-tab" role="tablist">
                                <li role="presentation" class="">
                                    <a href="#home" aria-controls="home" role="tab" class="onepage-tabs active"
                                       data-toggle="tab">
                                        <span>{{__('labels.stu_one_page_report')}}</span>
                                    </a>
                                </li>

                                <li role="presentation" class="">
                                    <a href="{{ route('students.reservation.index') }}" class="onepage-tabs" role="tab"
                                       data-toggle="tab">
                                        <span>{{__('labels.stu_reservation_lesson_record')}}</span>
                                    </a>
                                </li>

                                <li role="presentation" class="">
                                    <a href="{{ route('students.keywords.index') }}" class="onepage-tabs" role="tab"
                                       data-toggle="tab">
                                        <span>{{__('labels.stu_keyword_phrases')}}</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="home">
                                    @if (!empty($booking) && $booking->toArray())
                                        @include('students.onepage.index.onepage')
                                    @else
                                        <div class="one_pg_tab stud">
                                            <div class="row text-center">
                                                <div class="col-12">
                                                    <p>{{__('labels.stu_not_complete_any_lessons')}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <hr>

                                    <!-- share record  -->
                                    <div class="row">
                                    	<div class="col-12">
	                                        @include('students.onepage.index.onepage.share_record')
                                        </div>
                                    </div>
                                    <!-- share record -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php
    // $CA = !empty($avgRatData['CA']) ? $avgRatData['CA'] : 0;
    // $FP = !empty($avgRatData['FP']) ? $avgRatData['FP'] : 0;
    // $LC = !empty($avgRatData['LC']) ? $avgRatData['LC'] : 0;
    // $V = !empty($avgRatData['V']) ? $avgRatData['V'] : 0;
    // $GA = !empty($avgRatData['GA']) ? $avgRatData['GA'] : 0;
    // $AVE = ($CA + $FP + $LC + $V + $GA) / 5;
    $CA = !empty($booking['ca_rating']) ? $booking['ca_rating'] : 5;
    $FP = !empty($booking['fp_rating']) ? $booking['fp_rating'] : 5;
    $LC = !empty($booking['lc_rating']) ? $booking['lc_rating'] : 5;
    $V = !empty($booking['v_rating']) ? $booking['v_rating'] : 5;
    $GA = !empty($booking['ga_rating']) ? $booking['ga_rating'] : 5;
    $AVE = ($CA + $FP + $LC + $V + $GA) / 5;
    ?>

    @push('scripts')
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.js"></script>
        @if(Session::has('message'))
            <script>
                $.toast({
                    heading: 'Success',
                    text: "<?= Session::get('message') ?>",
                    icon: 'success',
                    position: 'top-right',
                    hideAfter: 10000
                })
            </script>
        @endif

        @if(Session::has('error'))
            <script>
                $.toast({
                    heading: 'Error',
                    text: "<?= Session::get('error') ?>",
                    icon: 'error',
                    position: 'top-right',
                })
            </script>
        @endif
        <script>
            $(document).on('click', '.onepage-tabs', function (e) {
                e.preventDefault();
                window.location.href = $(this).attr('href');
            });

            <?php
                $lastID = 0;
                if (isset($emails) && (!($emails->isEmpty()))) {
                    $total = count($emails);
                    $lastID = $emails[$total - 1]['id'];
                }
                ?>

                optionAction = {
                inx: {{ (isset($emails)) ? ($lastID+1) : 1 }},
                mchtml: <?= json_encode(View::make('students.dashboard.index.email.form')->render()) ?>,
                addOption: function () {
                    var type = $('#question_type').val();

                    $('#email-container').append(this.mchtml.replace(/{inx}/g, this.inx));
                    $('#title-' + this.inx).rules("add", {
                        pattern: /^\b[a-z0-9._]+@[a-z_]+?\.[a-z]{2,3}\b$/i,
                        required: true,
                        messages: {
                            pattern: "Enter valid email",
                            required: "Please enter email"
                        }
                    });
                    this.inx++;
                },
                removeOption: function (dis) {
                    var i = $(dis).data('id');
                    $('#email-' + i).remove();
                    //this.inx--;
                }
            }

            $("#frm_share_record").validate()

            $(document).ready(function () {
                $('input[data-email]').each(function (index, value) {
                    var id = $(value).attr('id');
                    console.log($("input#" + id));
                    console.log(value);
                    $(value).rules("remove");
                    $(value).rules("add", {
                        pattern: /^\b[a-z0-9._]+@[a-z_]+?\.[a-z]{2,3}\b$/i,
                        required: true,
                        messages: {
                            pattern: "Enter valid email",
                            required: "Please enter email"
                        }
                    });
                });
            })


        </script>
        @isset($drive_id)
            @if($drive_id != null)
                <script type="text/javascript">
                    $(document).on('click', '#up_drive', function () {
                        $('.upload_to_drive').trigger('click');
                    });

                    $(document).on('click', '.search-toggle', function () {
                        $('.search_drive').toggle();
                    });

                    $(document).on('click', '.prev', function () {
                        var folder_id = '{{$drive_id}}';
                        getData(folder_id, '');
                    });

                    $(document).on('keyup', '.search_drive', function () {
                        var value = $(this).val().toLowerCase().trim();
                        $(".file_inner").show().filter(function () {
                            return $(this).find('.name-file').text().toLowerCase().trim().indexOf(value) == -1;
                        }).hide();
                    });

                    $(document).on('change', '.upload_to_drive', function () {
                        var formData = (this.files);

                        var fileSize = 0;
                        $.each(formData, function () {
                            fileSize = fileSize + this.size;
                        })

                        var form_data = new FormData();
                        for (var i = 0; i < formData.length; i++) {
                            form_data.append("file[]", formData[i]);
                        }

                        var open_folder_id = $('.active_folder').val();

                        if (fileSize > 52428800) {
                            $.toast({
                                heading: 'File Size',
                                text: "{{__('jsValidate.required.upload_file_less_50_mb')}}",
                                icon: 'fail',
                                position: 'top-right',
                            });
                            return false;
                        }

                        form_data.append('folder_id', open_folder_id);


                        $.ajax({
                            data: form_data,
                            url: "{{route('students.dashboard.get.uploadfile')}}",
                            processData: false,
                            contentType: false,
                            type:
                                'POST',
                            headers:
                                {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                            beforeSend: function () {
                                $('.app-loader').removeClass('d-none');
                            },
                            cache: false,
                            success: function (resp) {
                                if (resp.type == 'success') {
                                    $('.app-loader').addClass('d-none');
                                }
                            }
                        });
                    });

                    let main_drive_id = "{{$drive_id}}";
                    let folderDataUrl = "{{route('students.dashboard.get.folderdata')}}";

                    $(document).on('click', '.main_folder,.get_home', function () {
                        var folder_id = $(this).attr('data-id');
                        var folder_name = $(this).attr('data-name');
                        getData(folder_id, folder_name);
                    });

                    $(document).on('click', '.refresh', function () {
                        var folder_id = $('.active_folder').val();
                        var folder_name = $('.folder_name').text();
                        getData(folder_id, folder_name);
                    });

                    (function (window) {
                        function triggerCallback(e, callback) {
                            if (!callback || typeof callback !== 'function') {
                                return;
                            }
                            var files;
                            if (e.dataTransfer) {
                                files = e.dataTransfer.files;
                            } else if (e.target) {
                                files = e.target.files;
                            }
                            var formData = files;

                            var fileSize = 0;
                            $.each(formData, function () {
                                fileSize = fileSize + this.size;
                            })


                            var form_data = new FormData();
                            for (var i = 0; i < formData.length; i++) {
                                form_data.append("file[]", formData[i]);
                            }
                            // form_data.append('file', formData);
                            var open_folder_id = $('.active_folder').val();

                            if (fileSize > 52428800) {
                                $.toast({
                                    heading: 'File Size',
                                    text: "{{__('jsValidate.required.upload_file_less_50_mb')}}",
                                    icon: 'fail',
                                    position: 'top-right',
                                });
                                return false;
                            }

                            form_data.append('folder_id', open_folder_id);


                            $.ajax({
                                data: form_data,
                                url: "{{route('students.dashboard.get.uploadfile')}}",
                                processData: false,
                                contentType: false,
                                type:
                                    'POST',
                                headers:
                                    {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                beforeSend: function () {
                                    $('.app-loader').removeClass('d-none');
                                },
                                cache: false,
                                success: function (resp) {
                                    if (resp.type == 'success') {
                                        $('.app-loader').addClass('d-none');
                                        $('.output').empty();
                                    }
                                }
                            });


                            // callback.call(null, files);
                        }

                        function makeDroppable(ele, callback) {
                            var input = document.createElement('input');
                            input.setAttribute('type', 'file');
                            input.setAttribute('multiple', true);
                            input.style.display = 'none';
                            input.addEventListener('change', function (e) {
                                triggerCallback(e, callback);
                            });
                            ele.appendChild(input);

                            ele.addEventListener('dragover', function (e) {
                                e.preventDefault();
                                e.stopPropagation();
                                ele.classList.add('dragover');
                            });

                            ele.addEventListener('dragleave', function (e) {
                                e.preventDefault();
                                e.stopPropagation();
                                ele.classList.remove('dragover');
                            });

                            ele.addEventListener('drop', function (e) {
                                e.preventDefault();
                                e.stopPropagation();
                                ele.classList.remove('dragover');
                                triggerCallback(e, callback);
                            });

                            ele.addEventListener('click', function () {
                                input.value = null;
                                input.click();
                            });
                        }

                        window.makeDroppable = makeDroppable;
                    })(this);
                    (function (window) {
                        makeDroppable(window.document.querySelector('.Drag_files'), function (files) {
                            var output = document.querySelector('.output');
                            output.innerHTML = '';
                            for (var i = 0; i < files.length; i++) {
                                if (files[i].type.indexOf('image/') === 0) {
                                    output.innerHTML += '<img width="200" src="' + URL.createObjectURL(files[i]) + '" />';
                                }
                                output.innerHTML += '<p>' + files[i].name + '</p>';
                            }
                        });
                    })(this);


                    function getData(folder_id, folder_name) {
                        var data = {
                            folder_id: folder_id,
                            main_drive_id: main_drive_id
                        };

                        $.ajax({
                            data: data,
                            url: folderDataUrl,
                            dataType: 'JSON',
                            type: 'POST',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            beforeSend: function () {
                                $('.app-loader').removeClass('d-none');
                            },
                            success: function (resp) {
                                if (resp.type == 'success') {
                                    $('.upload_folder').html(resp.html);
                                    $('.app-loader').addClass('d-none');
                                    $('.active_folder').val(folder_id);
                                    $('.folder_name').text(folder_name);
                                }
                            }
                        })
                    }

                    $(document).on('click', '.main_file', function () {
                        $(this).find('a')[0].click();
                    })


                </script>
            @endif
        @endisset

        @include('students.onepage.index.onepage.details.trend-js')
		<script type="text/javascript">
		function show_japanes_text(span_id) {

            $('#' + span_id).toggle();
            if ($('.' + span_id).text() == 'Read More') {

            $('.' + span_id).text('Read Less');
            } else {

            $('.' + span_id).text('Read More');
            }
        }
		</script>
    @endpush
@endsection
