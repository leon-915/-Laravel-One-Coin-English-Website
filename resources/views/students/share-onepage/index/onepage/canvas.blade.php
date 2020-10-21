<div class="row mb-5">
    <div class="col-12 p-4 onepage-canvas-text" style="border: 1px solid;border-radius: 5px;">
        <?= $booking->canvas_html ?>
    </div>
</div>
<div class="row text-right">
    <div class="col-12">
        <ul class="btn-text-to-speech-list">
            @if (Auth::guest())
            @else
                @if (Auth::user()->user_type == 'teacher')
                    <li><button onclick="speak('div.onepage-canvas-text')" type="button">Play</button></li>
                    <li><button onclick="pause()" type="button">Pause</button></li>
                    <li><button onclick="resume()" type="button">Resume</button></li>
                    <li><button onclick="stop()" type="button">Stop</button></li>
                @endif
            @endif
            <li class="last_btn"><a href="https://translate.google.com/#en/ja/<?= str_replace(['<br>',' '],['%0A','%20'],strip_tags(nl2br($booking->canvas_html),'<br>')) ?>" class="translet_btn" target="_blank"><img src="{{ asset('images/lan.png') }}">
                {{__('labels.stu_translate_all')}}
            </a></li>
        </ul>

    </div>
</div>
<style>
    .btn-text-to-speech-list li{display: inline-block;}
    .btn-text-to-speech-list li button{
        color: #212529;
        background-color: white;
        border: 1px solid;
        font-size: 12px;
        border-radius: 4px;
        padding:0 5px;
        min-width: 60px;
    }
    .btn-text-to-speech-list li button:hover{
        background-color: #002e58;
        color: white;
        border: 1px solid;
        font-size: 12px;
        border-radius: 4px;
    }

    .btn-text-to-speech-list .last_btn{margin-left: 20px;}

    @media screen and (max-width: 767px) {
        .btn-text-to-speech-list li button{min-width: 45px;}
        .btn-text-to-speech-list .last_btn {margin-left: 0px;margin-top: 20px;}
        }

</style>
