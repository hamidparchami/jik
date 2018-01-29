@extends('layouts.front')

@section('main')
    <div class="container main-container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-right page-title"><h1>دسته بندی‌ها</h1></div>
                <div class="catalog-list-container-row">
                @php($column=1)
                @foreach($catalogs as $catalog)
                    <div class="catalog-list-container-column">
                        <div class="catalog-list-container-header"><img src="{{ $catalog->image }}" class="img-responsive" /></div>
                        <div class="catalog-list-container-footer rtl">
                            <div class="orange-title parent-catalog-name-in-list"><a href="/catalog/{{ $catalog->id }}"><strong>{{ $catalog->name }}</strong></a></div>
                            @foreach($catalog->children as $child)
                                <div><a href="/catalog/{{ $child->id }}">{{ $child->name }}</a></div>
                            @endforeach
                        </div>
                    </div>
                    {{--@if(0 == $column % 3)
                        </div>
                    <div class="row">
                    @endif--}}
                @php($column++)
                @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')

@endsection