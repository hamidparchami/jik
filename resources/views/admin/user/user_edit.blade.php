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
                        <div class="panel-heading">افزودن کاربر</div>
                        <div class="panel-body">
                            {{ csrf_field() }}
                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <select name="role_id" class="form-control rtl">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" @if($role->id == $user->role_id) selected @endif>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">نقش کاربر</div>
                            </div>

                            <div class="row form-row">
                                <div class="col-md-3">
                                    <input name="email" type="text" class="form-control" value="{{ (old('email')) ? old('email') : $user->email }}">
                                </div>
                                <div class="col-md-1">ایمیل</div>
                                <div class="col-md-4">
                                    <input name="name" type="text" class="form-control rtl" value="{{ (old('name')) ? old('name') : $user->name }}">
                                </div>
                                <div class="col-md-4">نام کاربر</div>
                            </div>

                            <div class="row form-row">
                                <div class="col-md-3">

                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-4">
                                    <input name="password" type="password" class="form-control">
                                </div>
                                <div class="col-md-4">رمز عبور</div>
                            </div>

                            <div class="row form-row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <input class="pointer" name="is_active" type="checkbox" @if(old('is_active') == 'on' || old('is_active') == '1' || $user->is_active == '1') checked @endif>
                                    </div>
                                </div>
                                <div class="col-md-4">کاربر فعال</div>
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
                                    <a href="/admin/user/manage" class="btn btn-warning">بازگشت</a>
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
@endsection