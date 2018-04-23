@extends('layouts.app')

@section('header_links')
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/awesome-bootstrap-checkbox.css">
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
        <form id="form1" method="post">
            <div class="row">
                <div class="col-md-12 text-right">
                    <div class="panel panel-default">
                        <div class="panel-heading rtl">ایجاد دسته</div>
                        <div class="panel-body">
                            {{ csrf_field() }}
                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <select name="catalog_id" class="form-control rtl">
                                        @foreach($catalogs as $catalog)
                                            <option value="{{ $catalog->id }}" @if($catalog->id == old('catalog_id')) selected @endif>{{ $catalog->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">کاتالوگ</div>
                            </div>

                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <select name="parent_id" class="form-control rtl">
                                        <option value="0" @if(old('parent_id') == 0) selected @endif>----------</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @if($category->id == old('parent_id')) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">والد</div>
                            </div>

                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <input name="name" type="text" class="form-control rtl" value="{{ old('name') }}">
                                </div>
                                <div class="col-md-4">نام</div>
                            </div>
                            <br />

                            <div class="row form-row">
                                <div class="col-md-8">
                                    <div class="input-group">
                                      <span class="input-group-btn">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                          <i class="fa fa-picture-o"></i> انتخاب
                                        </a>
                                      </span>
                                        <input id="thumbnail" class="form-control" type="text" name="image" value="{{ (old('image', (isset($category->image) ? $category->image : ''))) }}">
                                    </div>
                                    <img id="holder" style="margin-top:15px;max-height:100px;" src="{{ (old('image', (isset($category->image) ? $category->image : ''))) }}">
                                </div>
                                <div class="col-md-4">عکس دسته</div>
                            </div>

                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="checkbox checkbox-success">
                                        <input id="checkbox" class="styled" type="checkbox" name="is_active" @if(is_null(old('is_active')) || old('is_active') == 1) checked @endif>
                                        <label for="checkbox"></label>
                                    </div>
                                </div>
                                <div class="col-md-4">وضعیت</div>
                            </div>

                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="checkbox checkbox-info">
                                        <input id="checkbox2" class="styled" type="checkbox" name="is_important" @if(old('is_important') == 1) checked @endif>
                                        <label for="checkbox2"></label>
                                    </div>
                                </div>
                                <div class="col-md-4">مهم</div>
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
                                    <a href="/admin/content-category/manage" class="btn btn-warning">بازگشت</a>
                                </div>
                                <div class="col-md-1 col-sm-4 col-xs-4 text-left">
                                    <button type="submit" id="submit" class="btn btn-success">ذخیره</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="allowed_urls" id="allowed_urls" />
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