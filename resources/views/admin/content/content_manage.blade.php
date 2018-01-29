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
                <a class="btn btn-primary" href="/admin/content/create">ایجاد محتوا</a>
            </div>
            <div class="col-md-6 text-right rtl">
                <h4>لیست محتوا</h4>
            </div>
        </div>
        <hr>
        <table id="dataTable" class="table table-striped table-bordered dataTable" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>عملیات</th>
                <th>نحوع ارسال</th>
                <th>نوع محتوا</th>
                <th name="right-direction">متن</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>عملیات</th>
                <th>نحوع ارسال</th>
                <th>نوع محتوا</th>
                <th name="right-direction">متن</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($contents as $content)
                <tr>
                    <td>
                        <a href="/admin/content/edit/id/{{ $content->id }}">ویرایش</a> |
                        <a class="delete" href="/admin/content/delete/id/{{ $content->id }}">حذف</a>
                    </td>
                    <td>{{ $content->send_type }}</td>
                    <td>{{ $content->type }}</td>
                    <td class="rtl">
                        @if($content->is_active)
                            {{ str_limit($content->text, $limit = 100, $end = '...') }}
                        @else
                            <div style="text-decoration: line-through;">{{ str_limit($content->text, $limit = 100, $end = '...') }}</div>
                        @endif
                    </td>
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
                    { "width": "10%", "targets": [0] },
                    // { className: "text-right", "targets": [ 1 ] }
                ]
            });

            $('.delete').click(function () {
                return window.confirm("آیا از عملیات حذف اطمینان دارید؟");
            });
        });
    </script>
@endsection