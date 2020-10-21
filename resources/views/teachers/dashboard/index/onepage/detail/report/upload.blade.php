<div class="card-header" id="heading-2">
    <h5 class="mb-0">
        <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-2" aria-expanded="false"
           aria-controls="collapse-2">
            Upload ・ アップロード
        </a>
    </h5>
</div>
<div id="collapse-2" class="collapse" data-parent="#accordion"
     aria-labelledby="heading-2">
    <div class="card-body">
        <div class="upload_image">
            <div class="row">
                <div class="col-lg-3">
                    @if($booking->status=='booked')
                        <div class="drag_main">
                            <div class="Drag_files">
                                <div class="demo-droppable">
                                    <img src="{{ asset('images/canvas_drag.png') }}" alt="drag">
                                    Drag your file here...
                                </div>
                                <div class="output"></div>
                            </div>
                            <div class="drag_add">
                                <span>... or find document on your device</span>
                                <input name="file[]" type="file" style="display:none" class="upload_to_drive" multiple>
                                <a style="cursor:pointer;" class="freetrial_btn" id="up_drive">Add Files</a>
                                <p>Max file size : <b>50 MB</b></p>
                            </div>
                        </div>
                    @endif
                    <input type="hidden" class="active_folder" value="{{$open_folder_id}}">
                </div>

                <div class="col-lg-9">
                    <div class="upload_folder">
                        @include('teachers.dashboard.index.onepage.detail.report.drive')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
        // form_data.append('file', formData);

        var open_folder_id = $('.active_folder').val();

        if (fileSize > 52428800) {
            $.toast({
                heading: 'File Size',
                text: "Please upload file less than 50 MB",
                icon: 'fail',
                position: 'top-right',
            });
            return false;
        }

        form_data.append('folder_id', open_folder_id);

        $.ajax({
            data: form_data,
            url: "{{route('teachers.dashboard.get.uploadfile')}}",
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
    let folderDataUrl = "{{route('teachers.dashboard.get.folderdata')}}";

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


            // var formData = files[0];
            // var fileSize = files[0].size;
            // var form_data = new FormData();
            // form_data.append('file', formData);
            // var open_folder_id = $('.active_folder').val();
            //
            if (fileSize > 52428800) {
                $.toast({
                    heading: 'File Size',
                    text: "Please upload file less than 50 MB",
                    icon: 'fail',
                    position: 'top-right',
                });
                return false;
            }

            form_data.append('folder_id', open_folder_id);


            $.ajax({
                data: form_data,
                url: "{{route('teachers.dashboard.get.uploadfile')}}",
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
