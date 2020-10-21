<div class="card">
    <div class="card-header" id="v-heading-{{ $level->id }}">
        <h5 class="mb-0">
            <a class="collapsed" role="button"
                data-toggle="collapse"
                href="#v-collapse-{{ $level->id }}"
                aria-expanded="false"
                aria-controls="v-collapse-{{ $level->id }}">
                [V] Vocabulary・語彙
            </a>
        </h5>
    </div>
    <div id="v-collapse-{{ $level->id }}" class="collapse"
        data-parent="#accordion-one-page-level-{{$level->id}}"
        aria-labelledby="v-heading-{{ $level->id }}">
        <div class="card-body">
            <div class="row">
                <div class="v_content">
                    @foreach ($level->v as $cakey => $v)
                        <p>{{ $v->description_en }}</p>
                        {{-- <a href="#">ReadMore</a> --}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
