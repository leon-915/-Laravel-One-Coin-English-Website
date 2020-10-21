<?php
$search_query = isset($_REQUEST['search_query']) && $_REQUEST['search_query'] != '' ? $_REQUEST['search_query'] : '';
$radio_search_by = isset($_REQUEST['radio_search_by']) && $_REQUEST['radio_search_by'] != '' ? $_REQUEST['radio_search_by'] : '';
$keyword_checked = 'checked="checked"';
$onepage_checked = '';
if ($radio_search_by == 'onepage') {
	$onepage_checked = 'checked="checked"';
	$keyword_checked = '';
}
?>
<div class="row">
    <form name="frm-keyword-search" id="frm-keyword-search" action="<?php echo route('teachers.dashboard.getsearch');?>" method="post">
	  {{ csrf_field() }}
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="form-group has-search custom_search mb-3 ">
                        <input type="text" name="search_query" id="search_query" class="form-control" placeholder="Search in English or Japanese." value="{{ $search_query }}" required>
                        <button class="btn-search-keyword" type="submit"><i class="fa fa-search"></i> OnePage Search</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-4 col-12">
                    <div class="form-group">
                        <label class="checkcontainer">
                            <input type="radio" <?php echo $keyword_checked; ?> name="radio_search_by" class="radio-search-type" value="keyword"> Keyword
                            <span class="radiobtn"></span>
                        </label>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="form-group">
                        <label class="checkcontainer">
                            <input type="radio" <?php echo $onepage_checked;?> id="onepage_report_search" name="radio_search_by" class="radio-search-type" value="onepage"> OnePage Report
                            <span class="radiobtn"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
		<!--input type="hidden" name="ref" value="keywords"-->
    </form>
</div>

<script>
    $("input[type='radio']").on('click',function(){
		
        var searchby = $(this).val();
        if(searchby == 'keyword'){
            $('#search_query').attr('placeholder','Search in English or Japanese.');
        } else if (searchby == 'onepage') {
            $('#search_query').attr('placeholder','e.g. 170119 (YYMMDD) or 1701:John or 170119:John');
        } else {
            $('#search_query').attr('placeholder','Search in English or Japanese.');
        }
    });

    //$('#frm-keyword-search').on('submit',function (e) {
    $(document).ready(function(e) {
        //e.preventDefault();
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
