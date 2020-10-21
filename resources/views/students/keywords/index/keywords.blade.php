<div class="top_search_sec">
    @include('students.keywords.index.keyword-search')
</div>

<div class="reservation_keyword">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                * {{__('labels.google_translation_may_be_inaccurate')}}
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-12">
            @include('students.keywords.index.alpha-search')
        </div>
    </div> --}}
    <div id="keyword-search-table-container">
        @include('students.keywords.index.keywords.keyword-table')
    </div>
    {{-- <div class="row">
        <div class="col-12">
            @include('students.keywords.index.alpha-search')
        </div>
    </div> --}}
</div>

<style>
    .char-search{
        cursor: pointer;
    }
    .dt-buttons button.buttons-csv,
    .dt-buttons button.buttons-excel {
        font-size: 24px;
        background: transparent;
        border: 0;
        color: #002e58;
    }
    .dt-buttons button.buttons-csv:active,
    .dt-buttons button.buttons-excel:active {
        background: transparent;
        border: 0;
    }
</style>



