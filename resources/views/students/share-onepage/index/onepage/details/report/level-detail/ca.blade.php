<div class="card">
    <div class="card-header" id="ca-heading-{{ $level->id }}">
        <h5 class="mb-0">
            <a class="collapsed" role="button"
                data-toggle="collapse"
                href="#ca-collapse-{{ $level->id }}"
                aria-expanded="false"
                aria-controls="ca-collapse-{{ $level->id }}">
                [CA] Communicative Ability・コミュニケーション能力
            </a>
        </h5>
    </div>
    <div id="ca-collapse-{{ $level->id }}" class="collapse"
        data-parent="#accordion-one-page-level-{{$level->id}}"
        aria-labelledby="ca-heading-{{ $level->id }}">
        <div class="card-body">
            <div class="row">
                <div class="ca_content">
                    @foreach ($level->ca as $cakey => $ca)
                        <p>{{ $ca->description_en }}</p>
                        {{-- <a href="#">ReadMore</a> --}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
