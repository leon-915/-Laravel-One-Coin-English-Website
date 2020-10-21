<div class="top_search_sec">
    @include('teachers.dashboard.index.keyword-search')
</div>

<div class="reservation_keyword">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                * Google translations may be inaccurate.
            </div>
        </div>
    </div>

    <div id="keyword-search-table-container">
        @include('teachers.dashboard.index.keywords.keyword-table')
    </div>
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

<script>
    $(document).on('click','.char-search', function(e){
        e.preventDefault();
        var char = $(this).data('char');
        if(char == '∞'){
            $('#search-keyword').val('');
        } else {
            $('#search-keyword').val(char);
        }
        $('#search-keyword').trigger('keyup');
    });

    $(document).on('keyup','#search-keyword' ,function(e){
        e.preventDefault();
        if (typeof OTable !== 'undefined'){
            console.log('OTable triggered')
            OTable.draw(true);
        }

        if (typeof KTable !== 'undefined'){
            console.log('KTable triggered')
            KTable.draw(true);
        }
    });
</script>

