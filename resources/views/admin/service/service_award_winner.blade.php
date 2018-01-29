@extends('layouts.app')

@section('header_links')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
@endsection

@section('header_scripts')

@endsection

@section('content')
<div class="container main-container">
    <div id="form-errors" class="rtl"></div>
    <form method="post" id="form1">
        {{ csrf_field() }}
    {{--Servie Method Container--}}

        @foreach($winners as $winner)
        <input type="hidden" id="winner_id" name="winner_id[]" value="{{ $winner->id }}">
        <div class="row method_form">
            <div class="col-md-12 text-right">
                <div class="panel panel-default">
                    <div class="panel-heading">اطلاعات برنده <span class="close_form" data-winner-id="{{ $winner->id }}" style="color: #ff0000; float: left; cursor: pointer;">حذف</span></div>
                    <div class="panel-body">
                        <div class="row form-row">
                            <div class="col-md-3">
                                <input name="surname[]" class="form-control rtl" type="text" value="{{ $winner->surname }}" readonly>
                            </div>
                            <div class="col-md-1">نام خانوادگی</div>
                            <div class="col-md-4">
                                <input name="name[]" class="form-control rtl" type="text" value="{{ $winner->name }}" readonly>
                            </div>
                            <div class="col-md-4">نام</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <input name="phone[]" class="form-control" type="text" value="{{ $winner->phone }}" readonly>
                            </div>
                            <div class="col-md-4">شماره تماس</div>
                        </div>

                        {{--@if(winner->photo != '' && !is_null($winner->photo))--}}
                        <div class="row form-row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <input class="form-control" type="hidden" name="photo[]" value="@if($winner->photo != '' && !is_null($winner->photo)) {{ $winner->photo }} @else {{ NULL }} @endif">
                                <img src="{{ $winner->photo }}" style="margin-top:15px;max-height:100px;">
                            </div>
                            <div class="col-md-4">عکس کاور</div>
                        </div>
                        {{--@endif--}}

                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="row method_form" id="method_form">
            <div class="col-md-12 text-right">
                <div class="panel panel-default">
                    <div class="panel-heading">اطلاعات برنده <span class="close_form" style="color: #ff0000; float: left; cursor: pointer;">حذف</span></div>
                    <div class="panel-body">
                        <div class="row form-row">
                            <div class="col-md-3">
                                <input name="surname[]" class="form-control rtl" type="text">
                            </div>
                            <div class="col-md-1">نام خانوادگی</div>
                            <div class="col-md-4">
                                <input name="name[]" class="form-control rtl" type="text">
                            </div>
                            <div class="col-md-4">نام</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <input name="phone[]" class="form-control" type="text">
                            </div>
                            <div class="col-md-4">شماره تماس</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="input-group">
                              <span class="input-group-btn">
                                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                  <i class="fa fa-picture-o"></i> انتخاب
                                </a>
                              </span>
                                    <input id="thumbnail" class="form-control" type="text" name="photo[]">
                                </div>
                                <img id="holder" style="margin-top:15px;max-height:100px;">
                            </div>
                            <div class="col-md-4">عکس</div>
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
                            <button type="button" id="append_method" class="btn btn-primary">افزودن برنده</button>
                        </div>
                        <div class="col-md-9 col-sm-4 col-xs-4">
                            <a href="/admin/service/award/service_id/{{ $service_id }}" class="btn btn-warning">بازگشت</a>
                        </div>
                        <div class="col-md-1 col-sm-4 col-xs-4 text-left">
                            <button type="button" id="submit" class="btn btn-success">ذخیره</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <input type="hidden" name="award_id" value="{{ $award_id }}">
        <input type="hidden" name="service_id" value="{{ $service_id }}">
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

<script language="JavaScript">
    var counter = 1;
    $(document).ready(function(){

        $("#append_method").click(function(){
            var new_element = $("#method_form").clone(true).insertBefore("#action_buttons");
            new_element.fadeIn(200).fadeOut(200).fadeIn(200).fadeOut(200).fadeIn(200);
            new_element.attr('id', 'method_form_' + counter);
            new_element.find('input').val('');

        });

        $(".close_form").click(function(){
            if (window.confirm("آیا اطمینان دارید؟")) {
            var method_form_container = $(this).parents('.method_form');
                $("#form1").append('<input type="hidden" name="delete_id[]" value="' + $(this).data('winner-id') + '">');
                method_form_container.fadeOut(500, function(){
                    method_form_container.remove();
                });
            }
        });

        //save data
        $("#submit").click(function(){
            $("#loading-mask").show();
            var form_data = $("#form1").serialize();
            $.ajax({
                type: "POST",
                url: "/admin/service/award/winner/service_id/{{ $service_id }}/award_id/{{ $award_id }}",
                data: {'data':form_data, '_token': $('input[name=_token]').val()},
                success:function(data){
                    window.location.href = '/admin/service/award/service_id/{{ $service_id }}';
                    $("#form-errors").hide();
                    $("#loading-mask").hide();
                }, error:function(jqXhr){
                    $("#loading-mask").hide();
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

        });

    });
</script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>

<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endsection