@extends('admin.layouts.admin',['title'=>'Attachments'])

@section('title','Attachments')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Attachments </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.teachers.index') }}">Manage Teachers</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Attachments</li>
                </ol>
            </nav>
        </div>
        <div class="row grid-margin">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Attachments</h4>

                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                {{ $error }}
                            </div>
                            @endforeach
                        @endif

                        @if(!empty($attachments))
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-control-label" >Images</label>
                                    <div class="popup-gallery">
                                        <ul class="claimed-img-container img_container_part">
                                            @foreach($attachments as $value)
                                                @if (strpos($value['type'], 'image') !== false)
                                                    <li>
                                                        <a data-toggle="tooltip" data-placement="bottom"     title="" data-original-title="{{basename($value['attachment_url'])}}"  href="{{ asset($value['attachment_url']) }}" style="background: url({{ asset($value['attachment_url'])  }})">
                                                            <img src="{{ asset($value['attachment_url']) }}" >
                                                        </a>

                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-control-label" >{{ __('Attachments') }}</label>
                                    <ul class="claimed-img-container img_container_part">
                                        @foreach($attachments as $value)
                                            @if (strpos($value['type'], 'application') !== false)
                                                @if (strpos($value['attachment_url'], '.pdf') !== false)
                                                    <li>
                                                        <a class = "iframe-popup" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{basename($value['attachment_url'])}}"  href="{{ asset($value['attachment_url']) }}" style="background: url({{ asset($value['attachment_url'])  }})"><i class="fa fa-file-pdf-o" style="font-size:80px;color:black"></i>
                                                        </a>
                                                    </li>
                                                @elseif(((strpos($value['attachment_url'], '.doc') !== false) ||(strpos($value['attachment_url'], '.docx') !== false)))
                                                    <li>
                                                        <a class = "iframe-popup" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{basename($value['attachment_url'])}}"  href="{{ 'https://docs.google.com/gview?url='.url($value['attachment_url']).'&embedded=true' }}"
                                                            style="background: url({{ asset($value['attachment_url'])  }})"><i class="fa fa-file-word-o" style="font-size:80px;color:black"></i>
                                                        </a>
                                                    </li>
                                                @elseif(((strpos($value['attachment_url'], '.csv') !== false)))
                                                    <li>
                                                        <a class = "csv" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{basename($value['attachment_url'])}}" href="{{ asset($value['attachment_url']) }}"
                                                            style="background: url({{ asset($value['attachment_url'])  }})"><i class="fa fa-file-excel-o" style="font-size:80px;color:black"></i>
                                                        </a>
                                                    </li>
                                                @elseif(((strpos($value['attachment_url'], '.xls') !== false) ||(strpos($value['attachment_url'], '.xlsx') !== false)))
                                                    <li>
                                                        <a class = "excel" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{basename($value['attachment_url'])}}" href="{{ asset($value['attachment_url']) }}"
                                                            style="background: url({{ asset($value['attachment_url'])  }})"><i class="fa fa-file-excel-o" style="font-size:80px;color:black"></i>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endif
                                            @if(((strpos($value['attachment_url'],'txt') !== false)))
                                                <li>
                                                    <a class="iframe-popup" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{basename($value['attachment_url'])}}"  href="{{ asset($value['attachment_url']) }}"
                                                        style="background: url({{ asset($value['attachment_url'])  }})"
                                                        download ><i class="fa fa-file-text-o" style="font-size:80px;color:black"></i>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @if(!empty($teacherDetail['audio_attachment']))
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-control-label" >Audio Attachment</label>
                                    <ul class="claimed-img-container img_container_part">
                                        <li>
                                            <a class = "iframe-popup" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{basename($teacherDetail['audio_attachment'])}}" href="{{ asset($teacherDetail['audio_attachment']) }}"style="background: url({{ asset($teacherDetail['audio_attachment']) }})"><i class="fa fa-file-audio-o" style="font-size:80px;color:black"></i>
                                            </a>
                                        </li>     
                                    </ul>
                                </div>
                            </div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style type="text/css">

        .img_name {
          white-space: nowrap;
          width: 80px;
          height: 30px;
          overflow: hidden;
          text-overflow:ellipsis;
       /*   border: 1px solid #000000;*/
        }

        .img_name:hover {
          overflow: visible;
        }
        .popup-gallery ul{
            margin: 0;
            width: auto;
            display: inline-block;
            padding-left: 0;
        }

        .claimed-img-container > li {
            width: 90px;
            height: 90px;
            overflow: hidden;
            position: relative;
            display: inline-block;
            margin-right: 5px;
            margin-bottom: 5px;
            float: left;
            display: none;
            border-radius: 10px;
        }
        .claimed-img-container > li > a{
            width:100%;
            height: 100%;
            display: block;
            background-position: center !important;
            background-size: 150% !important;
            background-repeat: no-repeat !important
        }
        .claimed-img-container > li > a > img{
            width: 100%;
            height: 100%;
        // opacity: 0;
        }
        .claimed-img-container > li{
            display: list-item;
        }

        .image-source-link {
            color: #98C3D1;
        }

        .mfp-with-zoom .mfp-container,
        .mfp-with-zoom.mfp-bg {
            opacity: 0;
            -webkit-backface-visibility: hidden;
            /* ideally, transition speed should match zoom duration */
            -webkit-transition: all 0.3s ease-out;
            -moz-transition: all 0.3s ease-out;
            -o-transition: all 0.3s ease-out;
            transition: all 0.3s ease-out;
        }

        .mfp-with-zoom.mfp-ready .mfp-container {
                opacity: 1;
        }
        .mfp-with-zoom.mfp-ready.mfp-bg {
                opacity: 0.8;
        }

        .mfp-with-zoom.mfp-removing .mfp-container,
        .mfp-with-zoom.mfp-removing.mfp-bg {
            opacity: 0;
        }

        .mfp-iframe-scaler iframe {
            background: #f8f9fa;
        }
    </style>
    @push('scripts')
            <script type="text/javascript" src="{{ asset('plugins/magnific-popup/magnific-popup.min.js') }}"></script>
           {{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/js/fontawesome.min.js" integrity="sha256-TNt3hxvmQwcyyPTYevC79inikYlBxATH32Osdz0jc+s=" crossorigin="anonymous"></script> --}}

            <script>
                $(document).ready(function() {

                /*$('.popup-video').magnificPopup({
                    disableOn: 700,
                    type: 'iframe',
                    mainClass: 'mfp-fade',
                    removalDelay: 160,
                    preloader: false,
                    fixedContentPos: false,
                    gallery: {
                        enabled: true,
                        navigateByImgClick: true,
                        preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
                    },
                });*/

                $('.popup-gallery').magnificPopup({
                    delegate: 'a',
                    type: 'image',
                    tLoading: 'Loading image #%curr%...',
                    mainClass: 'mfp-img-mobile mfp-with-zoom',
                    gallery: {
                        enabled: true,
                        navigateByImgClick: true,
                        preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
                    }/*,
                    image: {
                        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                    }*/
                });

                $('.iframe-popup').magnificPopup({
                    type: 'iframe'
                });

              /*  $(".word").fancybox({
                  'width': 600, // or whatever
                  'height': 320,
                  'type': 'iframe'
                 });*/
            });
        </script>
    @endpush
@endsection
