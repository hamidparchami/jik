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
                        <div class="panel-heading rtl">ویرایش مطلب</div>
                        <div class="panel-body">
                            {{ csrf_field() }}
                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <select name="category_id" class="form-control rtl">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @if($category->id == $article->category_id) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">دسته</div>
                            </div>

                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <input name="title" type="text" class="form-control rtl" value="{{ (old('title')) ?: $article->title }}">
                                </div>
                                <div class="col-md-4">عنوان</div>
                            </div>

                            {{--<div class="row form-row">
                                <div class="col-md-8">
                                    <textarea name="short_content" class="form-control rtl" rows="4">{{ (old('short_content')) ?: $article->short_content }}</textarea>
                                </div>
                                <div class="col-md-4">متن کوتاه</div>
                            </div>--}}

                            <div class="row form-row">
                                <div class="col-md-8">
                                    <textarea name="content" class="form-control rtl" rows="4">{{ (old('content')) ?: $article->content }}</textarea>
                                </div>
                                <div class="col-md-4">متن کامل</div>
                            </div>

                            <br />

                           {{-- <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                  <span class="input-group-btn">
                                    <a id="image-selector" data-input="image" data-preview="holder" class="btn btn-primary">
                                      <i class="fa fa-picture-o"></i> انتخاب
                                    </a>
                                  </span>
                                        <input id="image" class="form-control" type="text" name="image" value="{{ (old('image')) ?: $article->image }}">
                                    </div>
                                    <img id="holder" src="{{ (old('image')) ?: $article->image }}" style="margin-top:15px;max-height:100px;">
                                </div>
                                <div class="col-md-4">عکس</div>
                            </div>
                            <br />

                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4"><input name="order" type="text" class="form-control" value="{{ (old('order')) ?: $article->order }}"></div>
                                <div class="col-md-4">ترتیب</div>
                            </div>
                            <br>--}}

                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="checkbox checkbox-success">
                                        <input id="checkbox" class="styled" type="checkbox" name="is_active" @if(($article->is_active == '1' && is_null(old('is_active'))) || (old('is_active') == 1)) checked @endif>
                                        <label for="checkbox"></label>
                                    </div>
                                </div>
                                <div class="col-md-4">انتشار</div>
                            </div>

                            {{--<div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="checkbox checkbox-info">
                                        <input id="checkbox2" class="styled" type="checkbox" name="is_important" @if(old('is_important') == 1 || $article->is_important) checked @endif>
                                        <label for="checkbox2"></label>
                                    </div>
                                </div>
                                <div class="col-md-4">مطلب مهم</div>
                            </div>--}}

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
                                    <a href="/admin/article/manage" class="btn btn-warning">بازگشت</a>
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
    {{--<script>
        $('#image-selector').filemanager('image');
    </script>--}}

    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        var ckeditor = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}',
            contentsLangDirection: 'rtl',
            enterMode: CKEDITOR.ENTER_BR,
            allowedContent: true,
        };

        // CKEDITOR.replace( 'short_content', ckeditor);
        CKEDITOR.replace( 'content', ckeditor);
    </script>
@endsection