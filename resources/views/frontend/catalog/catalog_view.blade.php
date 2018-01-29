@extends('layouts.front')

@section('main')
<div class="container main-container">
    <div class="row">
        <div class="col-md-12">
        @if($services->count())
            <div class="text-right page-title"><h1>{{ $catalog->name }}</h1></div>
            <div class="row services-list-in-catalog-view-row">
                @php($column=1)
                @foreach($services as $service)
                        <div class="col-md-2 text-center service-in-catalog-view-column">
                            <a href="/service/{{ $service->id }}">
                                <div class="service-in-catalog-view-header"><img src="{{ $service->icon }}" class="img-responsive" /></div>
                                <div class="service-in-catalog-view-footer">{{ $service->name }}</div>
                            </a>
                        </div>
                    @if(0 == $column % 6)
                        </div>
                    <div class="row services-list-in-catalog-view-row">
                    @endif
                    @php($column++)
                @endforeach
            </div>
        @else
            <div class="alert alert-warning rtl">هیچ سرویسی در این دسته‌بندی تعریف نشده است.</div>
        @endif
        </div>
    </div>
</div>

@endsection