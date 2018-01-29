@extends('layouts/front')

@section('main')
    {{--Start Awards--}}
    <div class="container main-container">
    @if($delivered_awards->count())
        @php($j=1)
        <div class="row service-award-container-row">
            @foreach($delivered_awards as $delivered_award)
                <div class="col-md-4 text-center service-award-container-container">
                    <div style="background-color: #f2f2f2; border: 1px solid #dbdbdb; direction: rtl; padding: 0px; height: 100%;">
                        <img class="img-responsive" src="{{ (!is_null($delivered_award->image) && $delivered_award->image != '') ? $delivered_award->image : $delivered_award->type->image }}" width="358" height="175">
                        <h4 class="orange-title">{{ $delivered_award->title }}</h4>
                        <div style="padding-bottom: 12px;">
                            <div class="row">
                                <div class="col-md-12">
                                    @if($delivered_award->winners->first() !== null && $delivered_award->winners->count() == 1)
                                        برنده: {{ $delivered_award->winners->first()['name'] }} {{ $delivered_award->winners->first()['surname'] }}<br />شماره تلفن: <span dir="ltr">{{ $delivered_award->filterPhoneNumber($delivered_award->winners->first()['phone']) }}</span>
                                    @elseif($delivered_award->winners->count() > 1)
                                        برنده: <a href="{{ url('/service') }}/{{ $delivered_award->service->id }}/delivered-awards#winners-grid" class="winners-list-link" data-award-title="{{ $delivered_award->title }}"> لیست برندگان </a><br /><br />
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">مهلت شرکت: {{ $delivered_award->display_date_end }}</div>
                            </div>
                            <div class="row" style="margin-top: 8px;">
                                <div class="col-md-12 text-center">@if(!is_null($delivered_award->staticPage)) <a class="award-static-page-link" href="/service/award/{{ $delivered_award->id }}/page">مراسم اهدای جوایز</a> @endif</div>
                            </div>
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