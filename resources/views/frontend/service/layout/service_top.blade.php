@extends('layouts.front')

@section('header_links')
<link href="/css/dataTables.bootstrap.min.css" rel="stylesheet">
@endsection
@section('main')
<div class="container main-container">
    <div class="row">
        <div class="col-md-10 col-xs-8 text-right">
            <div class="row">
                <div class="col-md-12"><h3>{{ $service->name }}</h3></div>
            </div>
            <div class="row">
                <div class="col-md-9"></div>
                <div class="col-md-3 text-right">
                    @if(1==2)
                    <div class="text-center service-already-registered-button">عضو این سرویس هستید</div>
                    @else
                    <a href="/service/landing/{{ $service->id }}" class="btn btn-success">عضویت</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-2 col-xs-4">
            <img class="service-icon img-responsive" src="{{ $service->icon }}" />
        </div>
    </div>

    @yield('service_main')
</div>
@endsection