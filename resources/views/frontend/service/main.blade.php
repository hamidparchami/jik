@extends('frontend.service.layout.service_top')

@section('service_main')
        <div class="row" style="margin-top: 50px;">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <ul class="nav nav-pills service-pills">
                    <li class="service-information-tab"><a href="/service/{{ $service->id }}/information">اطلاعات</a></li>
                    <li class="service-future-awards-tab"><a href="/service/{{ $service->id }}/awards">جوایز آینده</a></li>
                    <li class="service-delivered-awards-tab active"><a href="/service/{{ $service->id }}/delivered-awards">جوایز اهدا شده</a></li>
                </ul>
            </div>
            <div class="col-md-4"></div>
        </div>

        {{--Start Delivered Awards--}}
        @if($delivered_awards->count())
            @php($j=1)
            <div class="row service-award-container-row rtl">
                @foreach($delivered_awards as $delivered_award)
                    @if($j < 3)
                        <div class="col-md-6 text-center service-award-container-container">
                            <div style="background-color: #f2f2f2; border: 1px solid #dbdbdb; direction: rtl; padding: 0px; height: 100%;">
                                <img class="img-responsive" src="{{ (!is_null($delivered_award->image) && $delivered_award->image != '') ? $delivered_award->image : $delivered_award->type->image }}" width="558" height="270" style="margin-bottom: 20px; max-height: 270px;">
                                <h4 class="orange-title">{{ $delivered_award->title }}</h4>
                                {{--{!! $delivered_award->description !!}--}}
                                <div class="text-right" style="padding: 12px;">
                                @if($delivered_award->winners->first() !== null && $delivered_award->winners->count() == 1)
                                    برنده: {{ $delivered_award->winners->first()['name'] }} {{ $delivered_award->winners->first()['surname'] }}<br />شماره تلفن: <span dir="ltr">{{ $delivered_award->filterPhoneNumber($delivered_award->winners->first()['phone']) }}</span>
                                @elseif($delivered_award->winners->count() > 1)
                                    برنده: <a href="{{ url('/service') }}/{{ $service->id }}/delivered-awards#winners-grid" class="winners-list-link" data-award-title="{{ $delivered_award->title }}"> لیست برندگان </a><br /><br />
                                @endif
                                    <div class="row">
                                        <div class="col-md-6">@if(!is_null($delivered_award->staticPage)) <a class="award-static-page-link" href="/service/award/{{ $delivered_award->id }}/page" style="float: left;">مراسم اهدای جوایز</a>@endif</div>
                                        <div class="col-md-6">مهلت شرکت: {{ $delivered_award->display_date_end }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($j == 3)
                        </div>
                        <div class="row award-in-middle-container">
                            <div class="col-md-3 text-center" style="padding-top: 100px;">
                                <h4 class="orange-title">{{ $delivered_award->title }}</h4>
                                <div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if($delivered_award->winners->first() !== null && $delivered_award->winners->count() == 1)
                                                برنده: {{ $delivered_award->winners->first()['name'] }} {{ $delivered_award->winners->first()['surname'] }}<br />شماره تلفن: <span dir="ltr">{{ $delivered_award->filterPhoneNumber($delivered_award->winners->first()['phone']) }}</span>
                                            @elseif($delivered_award->winners->count() > 1)
                                                برنده: <a href="{{ url('/service') }}/{{ $service->id }}/delivered-awards#winners-grid" class="winners-list-link" data-award-title="{{ $delivered_award->title }}"> لیست برندگان </a><br /><br />
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
                            <div class="col-md-9" style="padding-right: 0">
                                <img class="img-responsive" src="{{ (!is_null($delivered_award->image) && $delivered_award->image != '') ? $delivered_award->image : $delivered_award->type->image }}" width="800" height="410">
                            </div>
                        </div>
                        <div class="row service-award-container-row">
                    @else
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
                                            برنده: <a href="{{ url('/service') }}/{{ $service->id }}/delivered-awards#winners-grid" class="winners-list-link" data-award-title="{{ $delivered_award->title }}"> لیست برندگان </a><br /><br />
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
                    @endif
                @php($j++)
                @endforeach
            </div>
        @else
            <div class="alert alert-warning rtl" style="margin-top: 30px;">در حال حاضر جایزه‌ای در این قسمت تعریف نشده است.</div>
        @endif
        {{--End Delivered Awards--}}

        {{--Start Winners Grid--}}
        @if($delivered_awards->count())
            <div id="winners-grid" class="row delivered-awards-table-container">
                <div class="col-md-12">
                    <hr>
                    <h4 class="text-right">لیست برندگان</h4><br />
                    <table id="dataTable" class="table table-striped table-bordered dataTable" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            {{--<th>ارزش ریالی</th>--}}
                            <th>مهلت شرکت در قرعه‌کشی</th>
                            <th>شماره</th>
                            <th>جایزه</th>
                            <th>نام</th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($row = 1)
                        @foreach($delivered_awards as $delivered_award)
                            @foreach($delivered_award->winners as $winner)
                                <tr>
                                    {{--<td>{{ $delivered_award->price }}</td>--}}
                                    <td>{{ $delivered_award->display_date_start }}</td>
                                    <td>{{ $delivered_award->filterPhoneNumber($winner->phone) }}</td>
                                    <td>{{ $delivered_award->title }}</td>
                                    <td>{{ $winner->name }} {{ $winner->surname }}</td>
                                    <td>{{ $row }}</td>
                                </tr>
                                @php($row++)
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        {{--End Winners Grid--}}
@endsection

@section('footer_scripts')
    <script src="/js/persianDatepicker/js/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="/js/dataTables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="/js/dataTables/dataTables.bootstrap.min.js"></script>
    <script language="JavaScript">
        $(document).ready(function() {
            var oTable = $('#dataTable').DataTable({
                "language": {
                    "url": "/js/dataTables/i18n/Persian.json"
                },
                aaSorting: [[0, 'desc']],
//                "bLengthChange": false,
            });

            $('.winners-list-link').click(function(){
                oTable.search($(this).data('award-title')).draw();
            });

        });
    </script>
@endsection