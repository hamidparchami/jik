@extends('layouts.app')

@section('content')
<div class="container main-container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading rtl">ورود به سیستم</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="@if(!App::environment('local')){{ secure_url('/login') }}@else{{ url('/login') }}@endif">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-2"></div>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <label for="email" class="col-md-4 control-label" style="text-align: left;">ایمیل</label>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-2"></div>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <label for="password" class="col-md-4 control-label" style="text-align: left;">کلمه عبور</label>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> بخاطر بسپار
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <a class="btn btn-link rtl" href="{{ url('/password/reset') }}">کلمه عبور خود را فراموش کرده ام.</a>

                                <button type="submit" class="btn btn-primary">&nbsp; &nbsp;ورود&nbsp; &nbsp;</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
