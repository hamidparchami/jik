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
            <a class="btn btn-primary" href="/admin/service/create">ایجاد سرویس</a>
        </div>
        <div class="col-md-6 text-right">
            <h4>مدیریت سرویس ها</h4>
        </div>
    </div>
    <hr>
    <table id="dataTable" class="table table-striped table-bordered dataTable" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>عملیات</th>
            <th>وضعیت</th>
            <th>تاریخ پایان</th>
            <th>تاریخ شروع</th>
            <th>کاتالوگ</th>
            <th>نام سرویس</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>عملیات</th>
            <th>وضعیت</th>
            <th>تاریخ پایان</th>
            <th>تاریخ شروع</th>
            <th>کاتالوگ</th>
            <th>نام سرویس</th>
        </tr>
        </tfoot>
        <tbody>
        @foreach($services as $service)
        <tr>
            <td>
                <a href="/admin/service/award/service_id/{{ $service->id }}">لیست جوایز</a> | <a href="/admin/service/text-sample/service_id/{{ $service->id }}">نمونه محتوا</a> | <a href="/admin/service/edit/id/{{ $service->id }}">ویرایش</a> | <a class="delete" href="/admin/service/delete/id/{{ $service->id }}">حذف</a>
            </td>
            <td>
                <label class="switch">
                <input type="checkbox" @if($service->is_active == 1) checked @endif disabled name="service_status">
                <div class="slider round"></div>
                </label>
            </td>
            <td>{{ $service->date_end }}</td>
            <td>{{ $service->date_start }}</td>
            <td>{{ $service->catalog->name }}</td>
            <td>{{ $service->name }}</td>
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
                }
            });

            $('.delete').click(function () {
                return window.confirm("آیا از عملیات حذف اطمینان دارید؟");
            });
        });
    </script>
@endsection