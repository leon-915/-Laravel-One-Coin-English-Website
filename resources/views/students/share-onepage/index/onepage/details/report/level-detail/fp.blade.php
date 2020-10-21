<div class="card">
    <div class="card-header" id="fp-heading-{{ $level->id }}">
        <h5 class="mb-0">
            <a class="collapsed" role="button"
                data-toggle="collapse"
                href="#fp-collapse-{{ $level->id }}"
                aria-expanded="false"
                aria-controls="fp-collapse-{{ $level->id }}">
                [F&P] Fluency & Pronunciation・流暢さ&発音
            </a>
        </h5>
    </div>
    <div id="fp-collapse-{{ $level->id }}" class="collapse"
        data-parent="#accordion-one-page-level-{{$level->id}}"
        aria-labelledby="fp-heading-{{ $level->id }}">
        <div class="card-body">
            <div class="row">
                <div class="fp_content">
                    @foreach ($level->fp as $cakey => $fp)
                        <p>{{ $fp->description_en }}</p>
                        {{-- <a href="#">ReadMore</a> --}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
