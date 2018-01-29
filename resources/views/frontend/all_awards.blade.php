@extends('layouts/front')

@section('main')
    {{--Start Awards--}}
    <div class="container main-container">
    @if($awards->count())
        @php($j=1)
        <div class="row service-award-container-row">
            @foreach($awards as $award)
                <div class="col-md-4 text-center service-award-container-container">
                    <div style="background-color: #f2f2f2; border: 1px solid #dbdbdb; direction: rtl; padding: 0px; height: 100%">
                        <img class="img-responsive" src="{{ (!is_null($award->image) && $award->image != '') ? $award->image : $award->type->image }}" width="358" height="175">
                        <h4 class="orange-title">{{ $award->title }}</h4>
                        <div style="padding-bottom: 12px;">
                            <div class="row">
                                <div class="col-md-12">{!! $award->description !!}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">سرویس: <a href="/service/{{ $award->service->id }}">{{ $award->service->name }}</a></div>
                        </div>
                    </div>
                </div>
                @if(0 == $j % 3)
            </div>
        <div class="row service-award-container-row">
                @endif
            @php($j++)
            @endforeach
        </div>
    @else
        <div class="alert alert-warning rtl" style="margin-top: 30px;">در حال حاضر جایزه‌ای در این قسمت تعریف نشده است.</div>
    @endif
    {{--End Awards--}}
    </div>
@endsection