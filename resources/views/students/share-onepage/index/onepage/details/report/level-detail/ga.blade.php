<div class="card">
    <div class="card-header" id="ga-heading-{{ $level->id }}">
        <h5 class="mb-0">
            <a class="collapsed" role="button"
                data-toggle="collapse"
                href="#ga-collapse-{{ $level->id }}"
                aria-expanded="false"
                aria-controls="ga-collapse-{{ $level->id }}">
                [G&A] Grammar & Accuracy・文法/正確さ
            </a>
        </h5>
    </div>
    <div id="ga-collapse-{{ $level->id }}" class="collapse"
        data-parent="#accordion-one-page-level-{{$level->id}}"
        aria-labelledby="ga-heading-{{ $level->id }}">
        <div class="card-body">
            <div class="row">
                <div class="ga_content">
                    @foreach ($level->ga as $cakey => $ga)
                        <p>{{ $ga->description_en }}</p>
                        {{-- <a href="#">ReadMore</a> --}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
