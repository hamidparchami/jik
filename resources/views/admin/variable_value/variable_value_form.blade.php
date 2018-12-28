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
                    <div class="panel-heading">افزودن متغیر</div>
                    <div class="panel-body">
                        {{ csrf_field() }}
                        <div class="row form-row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <input name="variable" type="text" class="form-control rtl" value="{{ old('variable', (isset($variable_value->variable)) ? $variable_value->variable : '') }}">
                            </div>
                            <div class="col-md-4">نام متغیر</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <input name="value" type="text" class="form-control" value="{{ old('value', (isset($variable_value->value)) ? $variable_value->value : '') }}">
                            </div>
                            <div class="col-md-4">مقدار متغیر</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <label class="switch">
                                    <input name="is_active" type="checkbox" @if((old('is_active') == 'on') || (isset($variable_value->is_active) && $variable_value->is_active) == 1)) checked @endif>
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
                                <a href="/admin/variable-value/manage" class="btn btn-warning">بازگشت</a>
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