<div class="row">
    <form name="frm-keyword-search" id="frm-keyword-search">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="form-group has-search custom_search mb-3">
                        <input type="text" name="search-query" id="search-query" class="form-control" placeholder=" {{__('labels.search_in_english_or_japan')}}">
                        <button class="btn-search-keyword" type="submit"><i class="fa fa-search"></i>  {{__('labels.btn_search')}}</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-4 col-12">
                    <div class="form-group">
                        <label class="checkcontainer">
                            <input type="radio" checked name="radio-search-by" class="radio-search-type" value="keyword">  {{__('labels.stu_keyword')}}
                            <span class="radiobtn"></span>
                        </label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="form-group">
                        <label class="checkcontainer">
                            <input type="radio" name="radio-search-by" class="radio-search-type" value="onepage">  {{__('labels.stu_one_page_report')}}
                            <span class="radiobtn"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


