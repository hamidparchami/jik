@extends('layouts.front')

@section('header_links')
<link href="/css/dataTables.bootstrap.min.css" rel="stylesheet">
@endsection

@section('main')
<div class="container main-container">
    <div class="row">
        <div class="col-md-12">
            @if($award_static_page_images->count())
            <h4 class="text-right">تصاویر مراسم قرعه کشی</h4>
            <hr>
            <div class="row">
                @php($row = 1)
                @foreach($award_static_page_images as $award_static_page_image)
                    <div class="col-md-3">
                        <img class="img-responsive" src="{{ $award_static_page_image->image }}">
                    </div>

                    @if(0 == $row % 4)
                        </div>
                        <div class="row">
                    @endif
                @php($row++)
                @endforeach
            </div>
            @endif()
        </div>
    </div>

    @if($award_static_page->text != '')
    <div class="row" style="margin-top: 40px;">
        <div class="col-md-12 rtl">
            <h4 class="text-right">شرح مراسم قرعه کشی</h4>
            <hr>
            {{ $award_static_page->text }}
        </div>
    </div>
    @endif

    @if($award_static_page->video != '')
    <div class="row" style="margin-top: 40px;">
        <div class="col-md-12 text-center">
            <h4 class="text-right">ویدیو مراسم قرعه کشی</h4>
            <hr>
            <video class="award-static-page-video" controls>
                <source src="{{ $award_static_page->video }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
    @endif
</div>
@endsection


@section('footer_scripts')
    <script src="/js/PhotoSwipe/js/photoswipe.js"></script>
    <script src="/js/PhotoSwipe/js/photoswipe-ui-default.min.js"></script>

    <script language="JavaScript">
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "language": {
                    "url": "/js/dataTables/i18n/Persian.json"
                },
                "bLengthChange": false,
            });
        });
    </script>
@endsection