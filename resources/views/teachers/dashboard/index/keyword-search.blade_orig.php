<div class="row">
    <form name="frm-keyword-search" id="frm-keyword-search">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="form-group has-search custom_search mb-3 ">
                        <input type="text" name="search-query" id="search-query" class="form-control" placeholder="Search in English or Japanese.">
                        <button class="btn-search-keyword" type="submit"><i class="fa fa-search"></i> Search</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-4 col-12">
                    <div class="form-group">
                        <label class="checkcontainer">
                            <input type="radio" checked name="radio-search-by" class="radio-search-type" value="keyword"> Keyword
                            <span class="radiobtn"></span>
                        </label>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="form-group">
                        <label class="checkcontainer">
                            <input type="radio" name="radio-search-by" class="radio-search-type" value="onepage"> OnePage Report
                            <span class="radiobtn"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).on('change','input[name=radio-search-by]',function(e){
        e.preventDefault();
        var searchby = $(this).val();
        if(searchby == 'keyword'){
            $('#search-query').attr('placeholder','Search in English or Japanese.');
        } else if (searchby == 'onepage') {
            $('#search-query').attr('placeholder','e.g. 170119 (YYMMDD)');
        } else {
            $('#search-query').attr('placeholder','Search in English or Japanese.');
        }
    });

    $('#frm-keyword-search').on('submit',function (e) {
        e.preventDefault();
        var frmData = $(this).serialize();
        var searchType = $(".radio-search-type:checked").val();
        var query = $('#search-query').val();

        if(!query){
            return;
        }

        if(searchType == 'keyword'){
            $.ajax({
                url : "<?= route('teachers.dashboard.get.keywords.search.keywordonepage') ?>",
                data:$(this).serialize(),
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    $('#keyword-search-table-container').html('');
                    $('.app-loader').removeClass('d-none');
                },
                success: function (res) {
                    $('.app-loader').addClass('d-none');
                    if (res.type == 'success') {
                        if (typeof OTable !== 'undefined'){
                            delete OTable;
                        }
                        if (typeof KTable !== 'undefined'){
                            delete KTable;
                        }
                        $('#keyword-search-table-container').html(res.html);
                    }
                }
            });
        } else if (searchType == 'onepage') {
            $.ajax({
                url : "<?= route('teachers.dashboard.get.keywords.search.onepage') ?>",
                data:$(this).serialize(),
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    $('#keyword-search-table-container').html('');
                    $('.app-loader').removeClass('d-none');
                },
                success: function (res) {
                    $('.app-loader').addClass('d-none');
                    if (res.type == 'success') {
                        if (typeof KTable !== 'undefined'){
                            delete KTable;
                        }
                        if (typeof KOTable !== 'undefined'){
                            delete KOTable;
                        }
                        $('#keyword-search-table-container').html(res.html);
                    }
                }
            });
        }
    });


</script>
