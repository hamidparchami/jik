@extends('layouts.front')
@section('header_links')
    <!-- Important Owl stylesheet -->
    <link rel="stylesheet" href="/js/owl-carousel/owl.carousel.css">
    <!-- Default Theme -->
    <link rel="stylesheet" href="/js/owl-carousel/owl.theme.css">
    <!-- Include js plugin -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="/js/owl-carousel/owl.carousel.js"></script>
@endsection

@section('header_scripts')
<script>
$(document).ready(function() {

    $("#header-slider").owlCarousel({

    autoPlay: 3000, //Set AutoPlay to 3 seconds

    items : 3,
    itemsDesktop : [1200,3],
    itemsDesktopSmall : [979,3]

    });

    for (i=0; i < {{ count($catalogs) }}; i++) {
        var catalog_slider = $("#catalog-"+i);
        catalog_slider.owlCarousel({
            autoPlay: false, //3000 = Set AutoPlay to 3 seconds
            items: 6,
            itemsDesktop: [1199, 3],
            itemsDesktopSmall: [979, 3],
            rewindNav:false,
            afterAction: function(catalog_slider){
                if (this.itemsAmount > this.visibleItems.length) {
                    catalog_slider.parents('#catalog_slider').find('.next').show();
                    catalog_slider.parents('#catalog_slider').find('.prev').show();

                    if (this.currentItem == 0) {
                        catalog_slider.parents('#catalog_slider').find('.prev').hide();
                    }
                    if (this.currentItem == this.maximumItem) {
                        catalog_slider.parents('#catalog_slider').find('.next').hide();
                    }

                } else {
                    catalog_slider.parents('#catalog_slider').find('.next').hide();
                    catalog_slider.parents('#catalog_slider').find('.prev').hide();
                }
            }
        });
    }

    $(".next-catalog").click(function(){
        var event_id = $(this).data('catalog-id');
        $("#catalog-"+event_id).trigger('owl.next');
    });

    $(".prev-catalog").click(function(){
        var event_id = $(this).data('catalog-id');
        $("#catalog-"+event_id).trigger('owl.prev');
    });

});
</script>
@endsection

@section('main')
<div id="header-slider" class="owl-carousel">
    @foreach($slider_images as $slider_image)
        {{--<div class="col-md-4" style="background: url({{ $slider_image->image }}) no-repeat; background-size: 99% 239px; height: 239px;"></div>--}}
        <div class="item"><a href="{{ $slider_image->link }}"><img src="{{ $slider_image->image }}"></a></div>
    @endforeach
</div>

<div class="container">

    {{-- main page catalogs --}}
    @php($i=0)
    @foreach($catalogs as $catalog)
        @if(count($catalog->services) > 0)
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-12 text-right"><h4>{{ $catalog->name }}</h4></div>
        </div>
        <div class="row middle-col-slider" id="catalog_slider">
            <div id="prev-holder" class="col-md-1 text-right middle-col-slider-arrow">
                <div class="prev prev-catalog"  data-catalog-id="{{ $i }}"><img data-catalog-id="{{ $i }}" src="/images/arrow_left.png"></div>
            </div>
            <div class="col-md-10">
                <div id="catalog-{{ $i }}" class="owl-carousel">
                    @foreach($catalog->services as $service)
                        <div class="item">
                            <a href="/service/{{ $service->id }}">
                                <div class="text-center"><img class="middle-col-slider-image" src="{{ $service->icon }}" style="border-radius: 8px;"></div>
                                <div class="text-center" style="margin-top: 8px;">{{ $service->name }}</div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div id="next-holder" class="col-md-1 text-left middle-col-slider-arrow">
                <div class="next next-catalog"  data-catalog-id="{{ $i }}"><img src="/images/arrow_right.png"></div>
            </div>
        </div>
        @endif
    @php($i++)
    @endforeach

</div>

@endsection