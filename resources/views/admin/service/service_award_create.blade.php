@extends('layouts.app')

@section('header_links')
    <link href="/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/js/persianDatepicker/css/persianDatepicker-default.css" />
@endsection
@section('header_scripts')
    <script src="/js/persianDatepicker/js/jquery-1.10.1.min.js"></script>
    <script src="/js/persianDatepicker/js/persianDatepicker.min.js"></script>
    <script>
        var jq = $.noConflict();
        jq(document).ready(function() {
            jq("#display_date_start, #display_date_end").persianDatepicker();
        });
    </script>
@endsection


@section('content')
<div class="container main-container">
    @if (count($errors) > 0)
        <div class="alert alert-danger rtl">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post">
        <div class="row">
            <div class="col-md-12 text-right">
                <div class="panel panel-default">
                    <div class="panel-heading">افزودن جایزه</div>
                    <div class="panel-body">
                        {{ csrf_field() }}
                        <input type="hidden" name="service_id" value="{{ $service_id }}">
                        <div class="row form-row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <select name="award_type_id" class="form-control rtl">
                                @foreach($award_types as $award_type)
                                        <option value="{{ $award_type->id }}">{{ $award_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">توع جایزه</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-3">
                                <input name="count" type="text" class="form-control" value="{{ old('count') }}">
                            </div>
                            <div class="col-md-1">تعداد</div>
                            <div class="col-md-4">
                                <input name="title" type="text" class="form-control rtl" value="{{ old('title') }}">
                            </div>
                            <div class="col-md-4">عنوان جایزه</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-8">
                                <textarea name="description" class="form-control rtl" rows="5">{{ old('description') }}</textarea>
                            </div>
                            <div class="col-md-4">توضیح</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-8">
                                <div class="input-group">
                          <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                              <i class="fa fa-picture-o"></i> انتخاب
                            </a>
                          </span>
                                    <input id="thumbnail" class="form-control" type="text" name="image">
                                </div>
                                <img id="holder" style="margin-top:15px;max-height:100px;">
                            </div>
                            <div class="col-md-4">عکس جایزه<br /> 900x450</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-3">
                                <input name="display_date_end" id="display_date_end" class="form-control" type="text" value="{{ old('display_date_end') }}">
                            </div>
                            <div class="col-md-1">تاریخ پایان نمایش</div>
                            <div class="col-md-4">
                                <input name="display_date_start" id="display_date_start" class="form-control" type="text" value="{{ old('display_date_start') }}">
                            </div>
                            <div class="col-md-4">تاریخ شروع نمایش</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-3">
                                <div class="checkbox">
                                    <input name="important" type="checkbox" @if(old('important') == 'on' || old('important') == '1') checked @endif>
                                </div>
                            </div>
                            <div class="col-md-1">جایزه مهم</div>
                            <div class="col-md-4">
                                <input name="order" class="form-control" type="text" value="{{ old('order') }}">
                            </div>
                            <div class="col-md-4">اولویت نمایش</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-3">
                                <input name="price" class="form-control" type="text" value="{{ old('price') }}">
                            </div>
                            <div class="col-md-1">ارزش ریالی</div>
                            <div class="col-md-4">
                                <input name="minimum_point" class="form-control" type="text" value="{{ (old('minimum_point')) }}">
                            </div>
                            <div class="col-md-4">حداقل امتیاز</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="action_buttons">
            <div class="col-md-12 text-right">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2 col-sm-4 col-xs-4 text-left">

                            </div>
                            <div class="col-md-9 col-sm-4 col-xs-4">
                                <a href="/admin/service/award/service_id/{{ $service_id or '' }}" class="btn btn-warning">بازگشت</a>
                            </div>
                            <div class="col-md-1 col-sm-4 col-xs-4 text-left">
                                <button type="submit" id="submit" class="btn btn-success">ذخیره</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection

@section('footer_scripts')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>

<script>
$(document).ready(function() {

    $('#lfm').filemanager('image');
});

/*$.noConflict();
jQuery( document ).ready(function( $ ) {
    $('#display_date_start').datepicker();
});*/
</script>
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'description', {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}',
        contentsLangDirection: 'rtl',
        enterMode: CKEDITOR.ENTER_BR,
    });
</script>
@endsection