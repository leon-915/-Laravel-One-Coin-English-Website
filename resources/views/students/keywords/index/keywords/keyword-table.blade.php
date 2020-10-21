<div class="row clearfix ">
    <div class="col-12">
        @include('teachers.dashboard.index.alpha-search')
    </div>
</div>
<div class="row clearfix keyword-sec">
    <div class="col-4 clearfix" id="keyword-seach-text" style="position: relative;top: 22px;z-index: 50;">
        <div class="form-group has-search custom_search custom_search_keyword mb-3">
            <span class="fa fa-search form-control-feedback"></span>
            <input type="text" class="form-control" id="search-keyword" name="search" placeholder="{{__('labels.stu_search_keyword')}}">
        </div>
    </div>
    <div class="col-12" style="margin-top: -40px;">
        <div class="table-responsive keyword_table">
        	<div class="key-word-table">
            <table class="table" id="keyword-table" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">{{__('labels.stu_sr_no')}}</th>
                        <th scope="col">{{__('labels.stu_keyword')}}</th>
                        <th scope="col">{{__('labels.stu_translation')}}</th>
                        <th scope="col">{{__('labels.stu_topic')}}</th>
                        <th scope="col">{{__('labels.stu_date')}}</th>
                    </tr>
                </thead>
            </table>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-12">
        @include('teachers.dashboard.index.alpha-search')
    </div>
</div>
