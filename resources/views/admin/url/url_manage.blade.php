@extends('layouts.app')

@section('header_links')
    <link href="/css/dataTables.bootstrap.min.css" rel="stylesheet">
@endsection


@section('content')
    <div class="container main-container">
        @if (Session::has('message'))
            <div class="alert alert-success text-right rtl">{{ Session::get('message') }}</div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-primary" href="/admin/url/create">افزودن آدرس</a>
            </div>
            <div class="col-md-6 text-right rtl">
                <h4>لیست URL ها</h4>
            </div>
        </div>
        <hr>
        <table id="dataTable" class="table table-striped table-bordered dataTable" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>عملیات</th>
                <th>URL</th>
                <th name="right-direction">نام آدرس</th>
                <th>#</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>عملیات</th>
                <th>URL</th>
                <th name="right-direction">نام آدرس</th>
                <th>#</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($urls as $url)
                <tr>
                    <td>
                        <a href="/admin/url/edit/id/{{ $url->id }}">ویرایش</a> |
                        <a class="delete" href="/admin/url/delete/id/{{ $url->id }}">حذف</a>
                    </td>
                    <td>{{ $url->url }}</td>
                    <td>
                        @if(is_null($url->parent_id))
                            <strong>{{ $url->title }}</strong>
                        @else
                            {{ $url->title }}
                        @endif
                    </td>
                    <td rowspan="{{ $url->children->count()+1 }}"><span class="vertical-text">{{ $url->title }}</span></td>
                </tr>
                @foreach($url->children as $child)
                    <tr>
                        <td>
                            <a href="/admin/url/edit/id/{{ $child->id }}">ویرایش</a> |
                            <a class="delete" href="/admin/url/delete/id/{{ $child->id }}">حذف</a>
                        </td>
                        <td>{{ $child->url }}</td>
                        <td style="border-right: 1px solid #d3e0e9;">{{ $child->title }}</td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('footer_scripts')
    <script language="JavaScript">
        $(document).ready(function() {
            $('.delete').click(function () {
                return window.confirm("آیا از عملیات حذف اطمینان دارید؟");
            });
        });
    </script>
@endsection