@extends('layouts.app')
@section('header_links')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
                        <div class="panel-heading">ساخت کاتالوگ</div>
                        <div class="panel-body">
                            {{ csrf_field() }}
                            @if(isset($parent_catalog))
                            <div class="row form-row">
                                <div class="col-md-8">
                                    {{ $parent_catalog->name }}
                                    <input name="parent_id" type="hidden" value="{{ $parent_catalog->id }}">
                                </div>
                                <div class="col-md-4">دسته ی والد</div>
                            </div>
                            @endif

                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <input name="name" type="text" class="form-control rtl" value="{{ old('name', (isset($current_catalog->name) ? $current_catalog->name : '')) }}">
                                </div>
                                <div class="col-md-4">نام کاتالوگ</div>
                            </div>

                            <div class="row form-row">
                                <div class="col-md-8">
                                    <div class="input-group">
                                      <span class="input-group-btn">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                          <i class="fa fa-picture-o"></i> انتخاب
                                        </a>
                                      </span>
                                        <input id="thumbnail" class="form-control" type="text" name="image" value="{{ (old('image', (isset($current_catalog->image) ? $current_catalog->image : ''))) }}">
                                    </div>
                                    <img id="holder" style="margin-top:15px;max-height:100px;" src="{{ (old('image', (isset($current_catalog->image) ? $current_catalog->image : ''))) }}">
                                </div>
                                <div class="col-md-4">عکس کاتالوگ</div>
                            </div>

                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4"><input name="order" type="text" class="form-control" value="{{ old('order', (isset($current_catalog->order) ? $current_catalog->order : '')) }}"></div>
                                <div class="col-md-4">ترتیب</div>
                            </div>

                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <input name="is_important" type="checkbox" @if(old('is_important') == 'on' || old('is_important') == '1' || (isset($current_catalog->is_important) && $current_catalog->is_important == 1)) checked @endif>
                                    </div>
                                </div>
                                <div class="col-md-4">صفحه نخست</div>
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
                                    <a href="/admin/catalog/manage/{{ $parent_id or '' }}" class="btn btn-warning">بازگشت</a>
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
    <script src="/vendor/laravel-filemanager/js/lfm.js"></script>
    <script>
        $('#lfm').filemanager('image');
    </script>
@endsection