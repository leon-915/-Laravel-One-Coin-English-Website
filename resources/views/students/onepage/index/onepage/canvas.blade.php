<div class="row mb-5">
    <div class="col-12 p-4" style="border: 1px solid;border-radius: 5px;">
        <?= $booking->canvas_html ?>
    </div>
</div>
<div class="row text-right">
    <div class="col-12">
    <a href="https://translate.google.com/#en/ja/<?= str_replace(['<br>',' '],['%0A','%20'],strip_tags(nl2br($booking->canvas_html),'<br>')) ?>" class="translet_btn" target="_blank">
        <img src="{{ asset('images/lan.png') }}">{{__('labels.stu_translate_all')}}
    </a>
    </div>
</div>
