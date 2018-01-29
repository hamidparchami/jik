

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
                <a href="/admin/catalog/create" class="btn btn-primary">ایجاد کاتالوگ</a>
                @if(isset($parent_catalog))
                    <a href="/admin/catalog/create/{{ $parent_catalog->id }}" class="btn btn-info">ساخت زیر مجموعه</a>
                @endif
            </div>
            <div class="col-md-6 text-right">
                <h4>مدیریت کاتالوگ ها
                    @if(isset($parent_catalog))
                        <small>» {{ $parent_catalog->name }}</small>
                    @endif
                </h4>
            </div>
        </div>
        <hr>
        <table id="dataTable" class="table table-striped table-bordered dataTable" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>عملیات</th>
                <th>صفحه نخست</th>
                <th name="right-direction">نام کاتالوگ</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>عملیات</th>
                <th>صفحه نخست</th>
                <th name="right-direction">نام کاتالوگ</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($catalogs as $catalog)
                <tr>
                    <td>
                        <a href="/admin/catalog/edit/id/{{ $catalog->id }}/{{ $catalog->parent_id }}">ویرایش</a>{{-- | <a href="/admin/catalog/delete/id/{{ $catalog->id }}/{{ $catalog->parent_id }}">حذف</a>--}}
                    </td>
                    <td>{{ ($catalog->is_important == 1) ? "بلی" : "خیر" }}</td>
                    <td><a href="/admin/catalog/manage/{{ $catalog->id }}">{{ $catalog->name }}</a></td>
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
                    { "width": "20%", "targets": 0 },
                    { className: "text-right", "targets": [ 2 ] }
                ]
            });

            $('.delete').click(function () {
                return window.confirm("آیا از عملیات حذف اطمینان دارید؟");
            });
        });
    </script>
@endsection