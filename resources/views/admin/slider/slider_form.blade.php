@extends('layouts.app')

@section('header_links')
    <link href="/css/dataTables.bootstrap.min.css" rel="stylesheet">
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
                    <div class="panel-heading">افزودن اسلاید</div>
                    <div class="panel-body">
                        {{ csrf_field() }}
                        <div class="row form-row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <input name="title" type="text" class="form-control rtl" value="{{ old('title', (isset($slider_image->title)) ? $slider_image->title : '') }}">
                            </div>
                            <div class="col-md-4">عنوان اسلاید</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <input name="link" type="text" class="form-control" value="{{ old('link', (isset($slider_image->link)) ? $slider_image->link : '') }}">
                            </div>
                            <div class="col-md-4">لینک اسلاید</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-8">
                                <div class="input-group">
                          <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                              <i class="fa fa-picture-o"></i> انتخاب
                            </a>
                          </span>
                                    <input id="thumbnail" class="form-control" type="text" name="image" value="{{ old('image', (isset($slider_image->image)) ? $slider_image->image : '') }}">
                                </div>
                                <img id="holder" style="margin-top:15px;max-height:100px;" src="{{ old('image', (isset($slider_image->image)) ? $slider_image->image : '') }}">
                            </div>
                            <div class="col-md-4">عکس اسلاید</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <label class="switch">
                                    <input name="status" type="checkbox" @if((old('status') == 'on') || (isset($slider_image->status) && $slider_image->status) == 1)) checked @endif>
                                    <div class="slider round"></div>
                                </label>
                            </div>
                            <div class="col-md-4">وضعیت</div>
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
                                <a href="/admin/slider/manage" class="btn btn-warning">بازگشت</a>
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
    $('#lfm').filemanager('image');
</script>
@endsection