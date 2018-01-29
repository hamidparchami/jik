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
            {{--<a class="btn btn-danger" href="/admin/service/edit/id/{{ $service_id }}">بازگشت</a>--}}
            <a class="btn btn-primary" href="/admin/service/award/create/service_id/{{ $service_id }}">افزودن جایزه</a>
        </div>
        <div class="col-md-6 text-right">
            <h4>لیست جوایز سرویس </h4>
        </div>
    </div>
    <hr>
    <table id="dataTable" class="table table-striped table-bordered dataTable" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>عملیات</th>
            <th>تاریخ پایان</th>
            <th>تاریخ شروع</th>
            <th>تعداد</th>
            <th>عنوان جایزه</th>
            <th>نوع جایزه</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>نوع جایزه</th>
            <th>عنوان جایزه</th>
            <th>تعداد</th>
            <th>تاریخ شروع</th>
            <th>تاریخ پایان</th>
            <th>عملیات</th>
        </tr>
        </tfoot>
        <tbody>
        @foreach($awards as $award)
        <tr>
            <td>
                <a href="/admin/service/award/winner/service_id/{{ $award->service_id }}/award_id/{{ $award->id }}">برنده ها</a> |
                <a href="/admin/service/award/edit/service_id/{{ $award->service_id }}/award_id/{{ $award->id }}">ویرایش</a> |
                <a class="delete" href="/admin/service/award/delete/service_id/{{ $award->service_id }}/award_id/{{ $award->id }}">حذف</a>
            </td>
            <td>{{ $award->display_date_end }}</td>
            <td>{{ $award->display_date_start }}</td>
            <td>{{ $award->count }}</td>
            <td>{{ $award->title }}</td>
            <td>{{ $award->type->name or '-------' }}</td>
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
                return window.confirm("آیا از حذف جایزه اطمینان دارید؟");
            });
        });
    </script>
@endsection