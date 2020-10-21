<div class="card">
    <div class="card-header" id="lc-heading-{{ $level->id }}">
        <h5 class="mb-0">
            <a class="collapsed" role="button"
                data-toggle="collapse"
                href="#lc-collapse-{{ $level->id }}"
                aria-expanded="false"
                aria-controls="lc-collapse-{{ $level->id }}">
                [LC] Listening Comprehension・リスニングの理解力
            </a>
        </h5>
    </div>
    <div id="lc-collapse-{{ $level->id }}" class="collapse"
        data-parent="#accordion-one-page-level-{{$level->id}}"
        aria-labelledby="lc-heading-{{ $level->id }}">
        <div class="card-body">
            <div class="row">
                <div class="lc_content">
                    @foreach ($level->lc as $cakey => $lc)
                        <p>{{ $lc->description_en }}</p>
                        {{-- <a href="#">ReadMore</a> --}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
