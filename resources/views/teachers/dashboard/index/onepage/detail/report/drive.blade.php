<div class="upload_header">
    <div class="breadcum_left">
        <span class="get_home" data-id="{{$drive_id}}">
            <i class="fas fa-home"></i>Start
            <i class="fas fa-angle-double-left"></i>
        </span>
        <ul class="bread_cum">
            <li class="folder_name"></li>
        </ul>
    </div>
    <div class="bred_icon">
        <input type="text" name="search_drive" class="search_drive" style="display: none">
        <a class="search-toggle"><i class="fas fa-search"></i></a>
        {{--<a href=""><i class="fas fa-cog"></i></a>--}}
        <a class="refresh"><i class="fas fa-redo"></i></a>
    </div>
</div>
<div class="file">
    @if($drive_id != $open_folder_id)
        <div class="file_inner prev">
            <img src="{{ asset('images/canvas_folder.png')}}" alt="file">
            <p>Previous Folder </p>
        </div>
    @endif
    @if(count($drivefolders) > 0)
        @foreach($drivefolders as $folder)
            <div class="file_inner" title="{{$folder->name}}">
                @if($folder->mimeType =='application/vnd.google-apps.folder')
                    <span class="main_folder" data-id="{{$folder->id}}" data-name="{{$folder->name}}">
                        <img src="{{asset('images/canvas_folder1.png')}}" alt="file">
                    </span>

                @else
                    <span class="main_file" data-id="{{$folder->id}}" data-name="{{$folder->name}}">
                        <?php $url = "https://drive.google.com/uc?authuser=0&id=" . $folder->id . "&export=download"?>
                        <a href="{{$url}}" download>
                            <img src="{{asset('images/canvas_icon1.png')}}" alt="file">
                        </a>
                    </span>

                @endif
                <p class="name-file" >{{$folder->name}} </p>
            </div>
        @endforeach
    @endif

</div>
