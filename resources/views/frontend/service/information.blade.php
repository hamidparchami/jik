@extends('frontend.service.layout.service_top')

@section('service_main')


    <div class="row" style="margin-top: 50px;">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <ul class="nav nav-pills service-pills">
                <li class="service-information-tab active"><a href="/service/{{ $service->id }}/information">اطلاعات</a></li>
                <li class="service-future-awards-tab"><a href="/service/{{ $service->id }}/awards">جوایز آینده</a></li>
                <li class="service-delivered-awards-tab"><a href="/service/{{ $service->id }}/delivered-awards">جوایز اهدا شده</a></li>
            </ul>
        </div>
        <div class="col-md-4"></div>
    </div>


    @if(!is_null($service->description) && $service->description != '')
        <div class="row" style="margin-top: 40px;">
            <div class="col-md-12 rtl">
                <div class="service-info-container">
                    {!! $service->description !!}
                </div>
            </div>
        </div>
    @endif

    @if($service->textSamples->count())
        @php($columns=1)
        <div class="row service-text-sample-row rtl">
        @foreach($service->textSamples as $textSample)
            <div class="@if($service->textSamples->count() == 1) col-md-12 @elseif($service->textSamples->count() == 2) col-md-6 @else col-md-4 @endif text-center">
                <div class="service-text-sample-container">
                    <h4>نمونه محتوا</h4>
                    {!! nl2br(e($textSample->text)) !!}
                </div>
            </div>
            @if(0 == $columns % 3 && $service->textSamples->count() > 3)
            </div>
            <div class="row service-text-sample-row">
            @endif
        @php($columns++)
        @endforeach
        </div>
    @endif

        <div class="row" style="margin-top: 30px;">
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
@endsection