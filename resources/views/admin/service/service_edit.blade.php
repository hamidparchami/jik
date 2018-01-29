@extends('layouts.app')

@section('header_links')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="/js/persianDatepicker/css/persianDatepicker-default.css" />

    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/awesome-bootstrap-checkbox.css">
@endsection

@section('header_scripts')

@endsection

@section('content')
<div class="container main-container">
    <div class="row form-row">
        <div class="col-md-12"><a class="btn btn-info" href="/admin/service/award/service_id/{{ $service->id }}">لیست جوایز</a></div>
    </div>
    @if (count($errors) > 0)
        <div class="alert alert-danger rtl">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" id="form1">
        <div class="row">
        <div class="col-md-12 text-right">
            <div class="panel panel-default">
                <div class="panel-heading">اطلاعات سرویس</div>
                <div class="panel-body">
                        {{ csrf_field() }}
                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <select name="catalog_id" class="form-control rtl" id="sel1">
                                        @foreach($catalogs as $catalog)
                                        <option value="{{ $catalog->id }}" @if(isset($service) && ($catalog->id == $service->catalog_id || $catalog->id == old('catalog_id'))) selected @endif>{{ $catalog->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">کاتالوگ</div>
                            </div>

                        <div class="row form-row">
                            <div class="col-md-3">
                                <input name="short_description" class="form-control rtl" type="text" value="{{ (old('short_description')) ?: $service->short_description }}">
                            </div>
                            <div class="col-md-1">توضیح کوتاه</div>
                            <div class="col-md-4">
                                <input name="name" class="form-control rtl" type="text" value="{{ (old('name')) ?: $service->name }}">
                            </div>
                            <div class="col-md-4">نام سرویس</div>
                        </div>
                        <div class="row form-row">
                            <div class="col-md-3">
                                <input name="date_end" id="date_end" class="form-control" type="text" value="{{ (old('date_end')) ?: $service->date_end }}">
                            </div>
                            <div class="col-md-1">تاریخ پایان</div>
                            <div class="col-md-4">
                                <input name="date_start" id="date_start" class="form-control" type="text" value="{{ (old('date_start')) ?: $service->date_start }}">
                            </div>
                            <div class="col-md-4">تاریخ شروع</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-3">
                                <input name="display_awards_date_end" id="display_awards_date_end" class="form-control" type="text" value="{{ (old('display_awards_date_end')) ?: $service->display_awards_date_end }}">
                            </div>
                            <div class="col-md-1">نمایش جوایز تا</div>
                            <div class="col-md-4">
                                <input name="display_awards_date_start" id="display_awards_date_start" class="form-control" type="text" value="{{ (old('display_awards_date_start')) ?: $service->display_awards_date_start }}">
                            </div>
                            <div class="col-md-4">نمایش جوایز از</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-3">
                                <div class="checkbox checkbox-success">
                                    <input id="checkbox" class="styled" type="checkbox" name="is_active" @if(($service->is_active == '1' && is_null(old('is_active'))) || (old('is_active') == 1 || old('is_active') == 'on')) checked @endif>
                                    <label for="checkbox"></label>
                                </div>
                            </div>
                            <div class="col-md-1">وضعیت</div>
                            <div class="col-md-4">
                                <input name="price_description" class="form-control rtl" type="text" value="{{ (old('price_description')) ?: $service->price_description }}">
                            </div>
                            <div class="col-md-4">توضیح هزینه</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-3">
                                <div class="input-group">
                                      <span class="input-group-btn">
                                        <a id="icon" data-input="icon-input" data-preview="icon-holder" class="btn btn-primary">
                                          <i class="fa fa-picture-o"></i> انتخاب
                                        </a>
                                      </span>
                                    <input id="icon-input" class="form-control" type="text" name="icon" value="{{ (old('icon')) ?: $service->icon }}">
                                </div>
                                <img id="icon-holder" src="{{ old('icon', $service->icon) }}" style="margin-top:15px;max-height:100px;">
                            </div>
                            <div class="col-md-1">آیکن</div>
                            <div class="col-md-4">
                                <div class="input-group">
                                      <span class="input-group-btn">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                          <i class="fa fa-picture-o"></i> انتخاب
                                        </a>
                                      </span>
                                    <input id="thumbnail" class="form-control" type="text" name="cover_image" value="{{ (old('cover_image')) ?: $service->cover_image }}">
                                </div>
                                <img id="holder" src="{{ old('cover_image', $service->cover_image) }}" style="margin-top:15px;max-height:100px;">
                            </div>
                            <div class="col-md-4">عکس کاور</div>
                        </div>
                        <hr>
                        <div class="row form-row">
                            <div class="col-md-8">
                                <textarea name="description" class="form-control rtl" rows="4">{{ (old('description')) ?: $service->description}}</textarea>
                            </div>
                            <div class="col-md-4">توضیح کامل</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-8">
                                <textarea name="manual_register_description" class="form-control rtl" rows="4">{{ (old('manual_register_description')) ?: $service->manual_register_description}}</textarea>
                            </div>
                            <div class="col-md-4">توضیح عضویت دستی</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-8">
                                <textarea name="welcome_message" class="form-control rtl" rows="4">{{ (old('welcome_message')) ?: $service->welcome_message}}</textarea>
                            </div>
                            <div class="col-md-4">پیام خوش آمد</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-8">
                                <textarea name="increase_points_description" class="form-control rtl" rows="4">{{ (old('increase_points_description')) ?: $service->increase_points_description}}</textarea>
                            </div>
                            <div class="col-md-4">توضیح افزایش امتیاز</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-8">
                                <textarea name="disable_service_description" class="form-control rtl" rows="4">{{ (old('disable_service_description')) ?: $service->disable_service_description}}</textarea>
                            </div>
                            <div class="col-md-4">توضیح لغو سرویس</div>
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
                            {{--<button type="button" id="append_method" class="btn btn-primary">افزودن متود</button>--}}
                        </div>
                        <div class="col-md-9 col-sm-4 col-xs-4">
                            <a href="/admin/service/manage" class="btn btn-warning">بازگشت</a>
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

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>

<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script>
    $('#lfm').filemanager('image');
    $('#icon').filemanager('image');
</script>


<script src="/js/persianDatepicker/js/jquery-1.10.1.min.js"></script>
<script src="/js/persianDatepicker/js/persianDatepicker.min.js"></script>
<script>
var jq = $.noConflict();
jq(document).ready(function() {
    jq("#date_start, #date_end, #display_awards_date_start, #display_awards_date_end").persianDatepicker();
});
</script>

<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script>
    var ckeditor = {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}',
        contentsLangDirection: 'rtl',
        enterMode: CKEDITOR.ENTER_BR,
    };

    CKEDITOR.replace( 'description', ckeditor);
    CKEDITOR.replace( 'welcome_message', ckeditor);
    CKEDITOR.replace( 'manual_register_description', ckeditor);
    CKEDITOR.replace( 'increase_points_description', ckeditor);
    CKEDITOR.replace( 'disable_service_description', ckeditor);

    function CKupdate(){
        for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement();
    }
</script>
@endsection