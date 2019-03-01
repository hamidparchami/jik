@extends('layouts.app')

@section('header_links')
    <link href="/css/dataTables.bootstrap.min.css" rel="stylesheet">
@endsection


@section('content')
    <div class="container main-container">
        @if (Session::has('message'))
            <div class="alert alert-success text-right rtl">{{ Session::get('message') }}</div>
        @endif
        <div class="row">
            <div class="col-md-12 text-right rtl">
                <h4>گزارشات</h4>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">

            </div>
            <div class="col-md-4 text-right rtl" style="line-height: 2em">
                کاربران عضو اپلیکیشن: {{ $activeTokens }}<br>
                کاربران آزمایشی اپلیکیشن: {{ $temporaryTokens }}<br>
                اعضای سرویس: {{ $totalSubscribers }}<br>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')

@endsection