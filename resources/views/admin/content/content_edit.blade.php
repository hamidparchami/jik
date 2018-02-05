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
                        <div class="panel-heading rtl">ایجاد محتوا</div>
                        <div class="panel-body">
                            {{ csrf_field() }}
                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <select name="service_id" id="service_id" class="form-control rtl">
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" @if(isset($content) && ($service->id == $content->catalog_id || $service->id == old('service_id'))) selected @endif>{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">سرویس</div>
                            </div>

                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-2">
                                    <select name="send_type" id="send_type" class="form-control rtl">
                                        <option value="pull" @if((isset($content->send_type) && $content->send_type == 'pull') || (old('send_type') == 'pull')) selected @endif>ترتیبی - درخواستی</option>
                                        <option value="push" disabled="disabled" @if((isset($content->send_type) && $content->send_type == 'push') || (old('send_type') == 'push')) selected @endif>ارسال خودکار</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="type" id="type" class="form-control rtl">
                                        <option value="text" @if((isset($content->type) && $content->type == 'text') || (old('type') == 'text')) selected @endif>متنی</option>
                                        <option value="photo" @if((isset($content->type) && $content->type == 'photo') || (old('type') == 'photo')) selected @endif>عکس</option>
                                        <option value="video" @if((isset($content->type) && $content->type == 'video') || (old('type') == 'video')) selected @endif>ویدئو</option>
                                        <option value="audio" disabled="disabled" @if((isset($content->type) && $content->type == 'audio') || (old('type') == 'audio')) selected @endif>صوت</option>
                                    </select>
                                </div>
                                <div class="col-md-4">نوع محتوا</div>
                            </div>

                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <textarea name="text" class="form-control rtl" rows="6">{{ old('text') ?: $content->text }}</textarea>
                                </div>
                                <div class="col-md-4">متن</div>
                            </div>

                            <div class="row form-row" id="full_content_container" style="display: none;">
                                <div class="col-md-8">
                                    <textarea name="full_content" class="form-control rtl" rows="4">{{ (old('full_content')) ?: $content->full_content }}</textarea>
                                </div>
                                <div class="col-md-4">متن کامل</div>
                            </div>

                            <div class="row form-row" id="photo_url_container" style="display: none;">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                  <span class="input-group-btn">
                                    <a id="image-selector" data-input="photo_url" data-preview="holder" class="btn btn-primary">
                                      <i class="fa fa-picture-o"></i> انتخاب
                                    </a>
                                  </span>
                                        <input id="photo_url" class="form-control" type="text" name="photo_url" value="{{ old('photo_url', (isset($content->photo_url)) ? $content->photo_url : '') }}">
                                    </div>
                                    <img id="holder" style="margin-top:15px;max-height:100px;" src="{{ old('photo_url', (isset($content->photo_url)) ? $content->photo_url : '') }}">
                                </div>
                                <div class="col-md-4">عکس</div>
                            </div>

                            <div class="row form-row" id="video_url_container" style="display: none;">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                  <span class="input-group-btn">
                                    <a id="video-selector" data-input="video_url" data-preview="holder" class="btn btn-primary">
                                      <i class="fa fa-picture-o"></i> انتخاب
                                    </a>
                                  </span>
                                        <input id="video_url" class="form-control" type="text" name="video_url" value="{{ old('video_url', (isset($content->video_url)) ? $content->video_url : '') }}">
                                    </div>
                                    <img id="holder" style="margin-top:15px;max-height:100px;" src="{{ old('video_url', (isset($content->video_url)) ? $content->video_url : '') }}">
                                </div>
                                <div class="col-md-4">ویدئو</div>
                            </div>

                            <div class="row form-row" id="publish_time" style="display:none;">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <input name="publish_time" type="text" class="form-control" value="{{ old('publish_time') ?: $content->publish_time }}">
                                </div>
                                <div class="col-md-4">زمان انتشار</div>
                            </div>

                            <div class="row form-row" id="order">
                                <div class="col-md-4 rtl">ترتیب آخرین محتوا: <span id="last-content-order"></span></div>
                                <div class="col-md-4">
                                    <input name="order" type="text" class="form-control" value="{{ old('order') ?: $content->order }}">
                                </div>
                                <div class="col-md-4">ترتیب</div>
                            </div>

                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <input name="score" type="text" class="form-control" value="{{ old('score') ?: $content->score }}">
                                </div>
                                <div class="col-md-4">امتیاز</div>
                            </div>

                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <input name="reference" type="text" class="form-control" value="{{ old('reference') }}">
                                </div>
                                <div class="col-md-4">مرجع</div>
                            </div>

                            <div class="row form-row">
                                <div class="col-md-2">
                                    <div class="checkbox checkbox-success">
                                        <input id="checkbox" class="styled" type="checkbox" name="show_instant_view" @if(($content->show_instant_view == '1' && is_null(old('show_instant_view'))) || (old('show_instant_view') == 1 || old('show_instant_view') == 'on')) checked @endif>
                                        <label for="checkbox"></label>
                                    </div>
                                </div>
                                <div class="col-md-2 rtl">نمایش Instant View</div>
                                <div class="col-md-4">
                                    <div class="checkbox checkbox-success">
                                        <input id="checkbox" class="styled" type="checkbox" name="is_active" @if(($content->is_active == '1' && is_null(old('is_active'))) || (old('is_active') == 1 || old('is_active') == 'on')) checked @endif>
                                        <label for="checkbox"></label>
                                    </div>
                                </div>
                                <div class="col-md-4">انتشار</div>
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
                                    <a href="/admin/content/manage" class="btn btn-warning">بازگشت</a>
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
        $(document).ready(function () {
            var content_id = {{ $content->id }};

            checkType();
            checkSendType();
            getLastContentOrder($('#service_id').val(), content_id);

            $('#service_id').change(function () {
                getLastContentOrder($('#service_id').val(), content_id);
            });

            $('#send_type').change(function () {
                checkSendType();
            });

            $('#type').change(function () {
                checkType();
            });

            function checkSendType() {
                if ($('#send_type').val() == 'push') {
                    $('#publish_time').show();
                    $('#order').hide();
                } else {
                    $('#publish_time').hide();
                    $('#order').show();
                }
            }

            function checkType() {
                if ($('#type').val() == 'text') {
                    $('#full_content_container').show();
                    $('#photo_url_container').hide();
                    $('#video_url_container').hide();
                    // $('#audio_url').hide();
                } else if ($('#type').val() == 'photo') {
                    $('#full_content_container').hide();
                    $('#photo_url_container').show();
                    $('#video_url_container').hide();
                    // $('#audio_url').hide();
                } else if ($('#type').val() == 'video') {
                    $('#full_content_container').hide();
                    $('#photo_url_container').hide();
                    $('#video_url_container').show();
                    // $('#audio_url').hide();
                } else if ($('#type').val() == 'audio') {
                    $('#full_content_container').hide();
                    $('#photo_url_container').hide();
                    $('#video_url_container').hide();
                    // $('#audio_url').show();
                }
            }

            function getLastContentOrder(service_id, content_id) {
                $.ajax({
                    type: "GET",
                    url: "/admin/content/last-content-order/service_id/"+service_id+"/content_id/"+content_id,
                    data: {'_token': $('input[name=_token]').val()},
                    success:function(data){
                        // window.location.href = '/admin/service/manage';
                        console.log(data);
                        $("#last-content-order").html(data.order);
                    }, error:function(jqXhr){
                        // $("#loading-mask").hide();
                        if(jqXhr.status === 401) //redirect if not authenticated user.
                            $(location).prop('pathname', 'auth/login');
                        if(jqXhr.status === 422) {
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            setTimeout(function () {
                                $('#form-errors').fadeIn(200).fadeOut(200).fadeIn(200).fadeOut(200).fadeIn(200);
                            }, 1000);

                            var errors = jqXhr.responseJSON; //this will get the errors response data.
                            errorsHtml = '<div class="alert alert-danger"><ul>';
                            $.each(errors, function(key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                            });
                            errorsHtml += '</ul></di>';
                            $('#form-errors').html(errorsHtml);
                        }
                    }
                });
            }
        })
    </script>

    <script src="/vendor/laravel-filemanager/js/lfm.js"></script>
    <script>
        $('#image-selector').filemanager('image');
        $('#video-selector').filemanager('file');
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
            allowedContent: true,
        };

        CKEDITOR.replace( 'full_content', ckeditor);
    </script>
@endsection