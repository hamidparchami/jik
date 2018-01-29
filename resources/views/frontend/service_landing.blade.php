<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>سرویس کاتالوگ {{ (isset($page_title) ? ' | ' . $page_title : '') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/common.css" rel="stylesheet">
<!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <style>
        .sponsor-container img {
            @if(isset($query_string['sponsor']) && $query_string['sponsor'] == 0)
            display:none;
            @endif
        }
        .footer-container {
            @if(isset($query_string['footer']) && $query_string['footer'] == 0)
            display:none;
            @endif
        }
    </style>
</head>
<body>
<div id="loading-mask" class="loading"><div>لطفا کمی صبر کنید...</div></div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 landing-header-col">
            <div class="col-lg-12 landing-header-col-cover" style="background: url('{{ $service->cover_image }}') top center no-repeat;">
                <div class="row landing-login-form-container">
                    <div class="col-md-3"></div>
                    <div class="col-md-6" style="background: #FFFFFF; border-radius: 4px; /*height: 234px;*/ padding-top: 26px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">

                        <div id="form-errors" class="rtl"></div>
                        <div id="form_container">
                            {{--start phone number form--}}
                            <div id="phone_number_form_container">
                                <div class="row">
                                    <div class="col-md-12 text-center" style="direction: rtl; color: #50b748; font-size: 18px; margin-bottom: 10px;">{{ $service->name }}</div>
                                    <div class="col-md-12 text-center black-title" style="direction: rtl;">{{ $service->short_description }}</div>
                                </div>

                                <div class="row" style="padding-top: 20px;">
                                    {{ csrf_field() }}
                                    <div class="col-md-4 col-xs-4 text-center"><button id="register_button" class="btn btn-success landing-register-button">ثبت نام</button></div>
                                    <div class="col-md-8 col-xs-8 text-left">
                                        <div class="input-group">
                                            <span class="input-group-addon">09</span>
                                            <input type="text" class="form-control" id="phone_number" name="phone_number">
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 32px; margin-bottom: 26px;">
                                    <div class="col-md-6 sponsor-container">
                                        {{--<img class="sponsor-logo" src="/images/appson_logo.svg">--}}
                                        {{--<img src="/images/hamrah_aval_logo.png">--}}
                                    </div>
                                    <div class="col-md-6 text-right black-title">{{ $service->price_description }}</div>
                                </div>
                            </div>
                            {{--end phone number form--}}

                            {{--start verification code form--}}
                            <div id="verification_code_form_container" style="display: none;">
                                <div class="row">
                                    <div class="col-md-12 text-center" style="color: #50b748; font-size: 18px; margin-bottom: 10px;">{{ $service->name }}</div>
                                    <div class="col-md-12 text-center black-text" id="verification_desc">.کد فعال سازی با پیامک برای شما ارسال شد. لطفا کد را وارد کنید</div>
                                </div>

                                <div class="row" style="padding-top: 20px;">
                                    {{ csrf_field() }}
                                    <div class="col-md-4 text-center"><button id="verify_button" class="btn btn-success" style="width: 160px;">ثبت کد</button></div>
                                    <div class="col-md-8 text-left">
                                            <input type="text" class="form-control" id="verification_code" name="verification_code">
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 32px; margin-bottom: 26px;">
                                    <div class="col-md-6 sponsor-container">
                                        {{--<img class="sponsor-logo" src="/images/appson_logo.svg">--}}
                                        {{--<img src="/images/hamrah_aval_logo.png">--}}
                                    </div>
                                    <div class="col-md-6 text-right black-text">
                                        <div id="entered_phone_number"></div>
                                        <div><a id="try_again" style="cursor: pointer">شماره را اشتباه وارد کرده اید؟</a></div>
                                    </div>
                                </div>
                            </div>
                            {{--end verification code form--}}

                            {{--start result container--}}
                            <div id="result_container" style="display: none;">
                                <div class="row">
                                    <div class="col-md-12 text-center" style="color: #50b748; font-size: 18px; margin-bottom: 10px;">{{ $service->name }}</div>
                                    <div class="col-md-12 welcome_message text-center black-text" id="welcome_message"></div>
                                </div>
                                <div class="row" style="margin-top: 32px; margin-bottom: 26px;">
                                    <div class="col-md-12 text-left sponsor-container">
                                        {{--<img class="sponsor-logo" src="/images/appson_logo.svg">--}}
                                        {{--<img src="/images/hamrah_aval_logo.png">--}}
                                    </div>
                                </div>
                            </div>
                            {{--end result container--}}

                            {{--start mtn result container--}}
                            <div id="mtn_container" style="display: none;">
                                <div class="row">
                                    <div class="col-md-12 text-center" style="color: #50b748; font-size: 18px; margin-bottom: 10px;">{{ $service->name }}</div>
                                    <div class="col-md-12 text-center welcome_message text-center black-text" id="mtn_message"></div>
                                </div>
                                <div class="row" style="margin-top: 32px; margin-bottom: 26px;">
                                    <div class="col-md-12 text-left sponsor-container">
                                        {{--<img class="sponsor-logo" src="/images/appson_logo.svg">--}}
                                        {{--<img src="/images/hamrah_aval_logo.png">--}}
                                    </div>
                                </div>
                            </div>
                            {{--end mtn result container--}}
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="container landing-important-award-top-container">
        {{--Start Awards--}}
        @if($awards->count())
            <div class="row">
                <div class="col-md-4 hidden-sm hidden-xs"><img src="/images/title_left_bar.svg"></div>
                <div class="col-md-4 awards-bg-center"><div class="landing-awards-bg-center text-center">جوایز</div></div>
                <div class="col-md-4 hidden-sm hidden-xs" style="padding-left: 0;"><img src="/images/title_right_bar.svg"></div>
            </div>
            @php($i=1)
            @foreach($awards as $award)
            <div class="row important-award-container">
                <div class="@if(0 == $i % 2)col-md-7 @else col-md-7 col-sm-push-5 @endif"><img class="img-responsive" src="{{ $award->image }}"></div>
                <div class="@if(0 == $i % 2)col-md-5 @else col-md-5 col-sm-pull-7 @endif rtl award-description">
                    <div class="award-name">{{ $award->title }}</div>
                    {!! $award->description !!}
                </div>
            </div>
            @php($i++)
            @endforeach
            <div class="text-center" style="margin-top: 30px;">
                <a class="btn btn-success" href="{{ url('/service') }}/{{ $service->id }}/awards">جوایز بیشتر</a>
            </div>
        @endif
        {{--End Awards--}}

        {{--Start Delivered Awards--}}
        @if($delivered_awards->count())
            <div class="row landing-important-delivered-award-container">
                <div class="col-md-4 hidden-sm hidden-xs"><img src="/images/title_left_bar.svg"></div>
                <div class="col-md-4"><div class="landing-awards-bg-center">جوایز تحویل شده</div></div>
                <div class="col-md-4 hidden-sm hidden-xs" style="padding-left: 0;"><img src="/images/title_right_bar.svg"></div>
            </div>
            @php($j=1)
            <div class="row service-award-container-row">
                @foreach($delivered_awards as $delivered_award)
                <div class="col-md-4 text-center service-award-container-container">
                    <div style="background-color: #f2f2f2; border: 1px solid #dbdbdb; direction: rtl; padding: 22px; height: 100%;">
                        @if($delivered_award->winners->first() !== null && $delivered_award->winners->count() == 1) <strong>{{ $delivered_award->winners->first()['name'] }} {{ $delivered_award->winners->first()['surname'] }}</strong><br>  برنده@elseif($delivered_award->winners->count() > 1)<a href="{{ url('/service') }}/{{ $service->id }}/delivered-awards#winners-grid"> لیست برندگان </a> @endif {{ $delivered_award->title }}
                        <div style="margin-top: 20px; margin-bottom: 20px;"><img class="img-responsive" src="{{ (!is_null($delivered_award->image) && $delivered_award->image != '') ? $delivered_award->image : $delivered_award->type->image }}" style="border-radius: 50%;"></div>
                        {!! $delivered_award->description !!}
                    </div>
                </div>
                @if(0 == $j % 3)
                    </div>
                    <div class="row service-award-container-row">
                @endif
                @php($j++)
                @endforeach
            </div>
            <div class="text-center">
                <a class="btn btn-success" href="{{ url('/service') }}/{{ $service->id }}/delivered-awards">جوایز بیشتر</a>
            </div>
        @endif
        {{--End Delivered Awards--}}

    </div>


    <div class="container" style="margin-top: 100px; margin-bottom: 156px;">
        <div class="row">
            <div class="col-md-6 text-center">
                <div class="service-info-container">
                    <img src="/images/score.svg">
                    <h4>افزایش امتیاز</h4>
                    {!! $service->increase_points_description !!}
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="service-info-container">
                    <img src="/images/off_service.svg">
                    <h4>غیرفعال سازی</h4>
                    {!! $service->disable_service_description !!}
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="service-info-container">
                    <img src="/images/group_6.svg">
                    <h4>هزینه</h4>
                    {{ $service->price_description }}
                </div>
            </div>
        </div>
    </div>

    <div class="footer-container" style="border: 1px solid #dbdbdb; background-color: #f2f2f2; height: 100px; padding-top: 24px; line-height: 2.5em">
        <div class="text-center">
            {{--<img src="/images/appson_logo_bw.svg">--}}
            <br> © ۱۳۹۵
        </div>
    </div>
</div>
<!-- Scripts -->
<script src="/js/app.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script type="text/javascript">
$(document).ready(function () {
    $("#phone_number").keypress(function(e){
        if (e.which == 13) {
            $("#register_button").trigger( "click" );
            return false;
        }
    });

    $("#verification_code").keyup(function(e){
        if (e.which == 13 || $(this).val().length >= 5) {
            $("#verify_button").trigger( "click" );
            return false;
        }
    });

    $('#register_button').click(function () {

        var loading_mask = $('#loading-mask');
        var errors_container = $('#form-errors');

        loading_mask.height($(document).height());
        loading_mask.show();

        $.ajax({
            type: "POST",
            url: "/service/register",
            data: {'phone_number':$("#phone_number").val(), 'service_id' : {{ $service->id }}, '_token': $('input[name=_token]').val()},
            success:function(data){
                if (data.operator == 'mtn') {
                    errors_container.hide();
                    loading_mask.hide();
                    $('#mtn_message').html(data.message);
                    $('#phone_number_form_container').slideUp();
                    $('#mtn_container').slideDown();
                    $('#mtn_message').fadeIn(500).fadeOut(500).fadeIn(500).fadeOut(500).fadeIn(500);
                } else {
//                window.location.href = '/admin/service/manage';
                    errors_container.hide();
                    loading_mask.hide();
                    $('#entered_phone_number').html('09' + $("#phone_number").val());
                    $('#phone_number_form_container').slideUp();
                    $('#verification_code_form_container').slideDown();
                    $('#verification_code_form_container > #verification_code').val('');
                    $('#verification_desc').fadeIn(500).fadeOut(500).fadeIn(500).fadeOut(500).fadeIn(500);
                }
            }, error:function(jqXhr){
                loading_mask.hide();
                if(jqXhr.status === 401) //redirect if not authenticated user.
                    $(location).prop('pathname', 'auth/login');
                if(jqXhr.status === 422) {
                    var errors = jqXhr.responseJSON; //this will get the errors response data.
                    var errorsHtml = '<div class="alert alert-danger"><ul>';
                    $.each(errors, function(key, value) {
                        errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                    });
                    errorsHtml += '</ul></di>';
                    errors_container.html(errorsHtml);
                    errors_container.fadeIn(200).fadeOut(200).fadeIn(200).fadeOut(200).fadeIn(200);
                }
            }
        });

    });

    $('#verify_button').click(function () {
        var loading_mask = $('#loading-mask');
        var errors_container = $('#form-errors');

        loading_mask.height($(document).height());
        loading_mask.show();

        $.ajax({
            type: "POST",
            url: "/service/verify-number",
            data: {'phone_number':$("#phone_number").val(), 'verification_code':$("#verification_code").val(), 'service_id' : {{ $service->id }}, '_token': $('input[name=_token]').val()},
            success:function(data){
                errors_container.hide();
                loading_mask.hide();
                $('#verification_code_form_container').slideUp();
                $('#result_container').find($('#welcome_message')).html(data.msg);
                $('#result_container').slideDown();
            }, error:function(jqXhr){
                loading_mask.hide();
                if(jqXhr.status === 401) //redirect if not authenticated user.
                    $(location).prop('pathname', 'auth/login');
                if(jqXhr.status === 422) {
                    var errors = jqXhr.responseJSON; //this will get the errors response data.
                    var errorsHtml = '<div class="alert alert-danger"><ul>';
                    $.each(errors, function(key, value) {
                        errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                    });
                    errorsHtml += '</ul></di>';
                    errors_container.html(errorsHtml);
                    errors_container.fadeIn(200).fadeOut(200).fadeIn(200).fadeOut(200).fadeIn(200);
                }
            }
        });
    });

    $('#try_again').click(function () {
        $('#verification_code_form_container').slideUp();
        $('#phone_number_form_container').slideDown();
    });
});
</script>
</body>
</html>
