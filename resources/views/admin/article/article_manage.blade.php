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
                <a class="btn btn-primary" href="/admin/article/create">مطلب جدید</a>
            </div>
            <div class="col-md-6 text-right rtl">
                <h4>لیست مطالب</h4>
            </div>
        </div>
        <hr>
        <table id="dataTable" class="table table-striped table-bordered dataTable" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>عملیات</th>
                <th>انتشار یافته</th>
                <th>لینک</th>
                <th name="right-direction">عنوان مطلب</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>عملیات</th>
                <th>انتشار یافته</th>
                <th>لینک</th>
                <th name="right-direction">عنوان مطلب</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($articles as $article)
                <tr>
                    <td>
                        <a href="/admin/article/edit/id/{{ $article->id }}">ویرایش</a> |
                        <a class="delete" href="/admin/article/delete/id/{{ $article->id }}">حذف</a>
                    </td>
                    <td>@if($article->is_active == 1) بلی @else خیر @endif</td>
                    <td>{{ url('/') }}/article/{{ $article->id }}</td>
                    <td @if($article->is_important) style="font-weight: bold;" @endif><a href="/article/{{ $article->id }}" target="_blank">{{ $article->title }}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript" charset="utf8" src="/js/dataTables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="/js/dataTables/dataTables.bootstrap.min.js"></script>
    <script type="application/json" charset="utf-8" src="//cdn.datatables.net/plug-ins/1.10.12/i18n/Persian.json"></script>
    <script language="JavaScript">
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "language": {
                    "url": "/js/dataTables/i18n/Persian.json"
                },
                "columnDefs": [
                    { "width": "20%", "targets": [0,1] },
                    { className: "text-right", "targets": [ 3 ] }
                ]
            });

            $('.delete').click(function () {
                return window.confirm("آیا از عملیات حذف اطمینان دارید؟");
            });
        });
    </script>
@endsection