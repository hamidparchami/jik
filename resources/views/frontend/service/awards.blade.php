@extends('frontend.service.layout.service_top')

@section('service_main')
        <div class="row" style="margin-top: 50px;">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <ul class="nav nav-pills service-pills">
                    <li class="service-information-tab"><a href="/service/{{ $service->id }}/information">اطلاعات</a></li>
                    <li class="service-future-awards-tab active"><a href="/service/{{ $service->id }}/awards">جوایز آینده</a></li>
                    <li class="service-delivered-awards-tab"><a href="/service/{{ $service->id }}/delivered-awards">جوایز اهدا شده</a></li>
                </ul>
            </div>
            <div class="col-md-4"></div>
        </div>

        {{--Start Delivered Awards--}}
        @if($awards->count())
            @php($j=1)
            <div class="row service-award-container-row">
                @foreach($awards as $award)
                    @if($j < 3)
                        <div class="col-md-6 text-center service-award-container-container">
                            <div style="background-color: #f2f2f2; border: 1px solid #dbdbdb; direction: rtl; padding: 0px; height: 100%;">
                                <img class="img-responsive" src="{{ (!is_null($award->image) && $award->image != '') ? $award->image : $award->type->image }}" width="558" height="270" style="margin-bottom: 20px; max-height: 270px;">
                                <h4 class="orange-title">{{ $award->title }}</h4>
                                {{--{!! $award->description !!}--}}
                                <div class="text-right" style="padding: 12px;">{!! $award->description !!}</div>
                            </div>
                        </div>
                    @elseif($j == 3)
                        </div>
                        <div class="row award-in-middle-container">
                            <div class="col-md-3 text-center" style="padding-top: 100px;">
                                <h4 class="orange-title">{{ $award->title }}</h4>
                                <div>
                                    <div class="row">
                                        <div class="col-md-12">{!! $award->description !!}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9" style="padding-right: 0">
                                <img class="img-responsive" src="{{ (!is_null($award->image) && $award->image != '') ? $award->image : $award->type->image }}" width="800" height="410">
                            </div>
                        </div>
                        <div class="row service-award-container-row">
                    @else
                        <div class="col-md-4 text-center service-award-container-container">
                            <div style="background-color: #f2f2f2; border: 1px solid #dbdbdb; direction: rtl; padding: 0px; height: 100%">
                                <img class="img-responsive" src="{{ (!is_null($award->image) && $award->image != '') ? $award->image : $award->type->image }}" width="358" height="175">
                                <h4 class="orange-title">{{ $award->title }}</h4>
                                <div style="padding-bottom: 12px;">
                                    <div class="row">
                                        <div class="col-md-12">{!! $award->description !!}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(0 == $j % 3)
                        </div>
                        <div class="row service-award-container-row">
                        @endif
                    @endif
                @php($j++)
                @endforeach
            </div>
        @else
            <div class="alert alert-warning rtl" style="margin-top: 30px;">در حال حاضر جایزه‌ای در این قسمت تعریف نشده است.</div>
        @endif
        {{--End Delivered Awards--}}
@endsection