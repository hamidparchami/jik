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
            <a class="btn btn-primary" href="/admin/slider/create">افزودن اسلاید</a>
        </div>
        <div class="col-md-6 text-right">
            <h4>مدیریت اسلایدر</h4>
        </div>
    </div>
    <hr>
    <table id="dataTable" class="table table-striped table-bordered dataTable" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>عملیات</th>
            <th>وضعیت</th>
            {{--<th>تاریخ پایان</th>
            <th>تاریخ شروع</th>--}}
            <th name="right-direction">عنوان اسلاید</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>عملیات</th>
            <th>وضعیت</th>
            {{--<th>تاریخ پایان</th>
            <th>تاریخ شروع</th>--}}
            <th name="right-direction">عنوان اسلاید</th>
        </tr>
        </tfoot>
        <tbody>
        @foreach($slider_images as $slider_image)
        <tr>
            <td>
                <a href="/admin/slider/edit/id/{{ $slider_image->id }}">ویرایش</a> | <a class="delete" href="/admin/slider/delete/id/{{ $slider_image->id }}">حذف</a>
            </td>
            <td>
                <label class="switch">
                <input type="checkbox" @if($slider_image->status == 1) checked @endif disabled name="service_status">
                <div class="slider round"></div>
                </label>
            </td>
            {{--<td>{{ $slider_image->date_end }}</td>
            <td>{{ $slider_image->date_start }}</td>--}}
            <td>{{ $slider_image->title }}</td>
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
                    { className: "text-right", "targets": [2] }
                ]
            });

            $('.delete').click(function () {
                return window.confirm("آیا از عملیات حذف اطمینان دارید؟");
            });
        });
    </script>
@endsection