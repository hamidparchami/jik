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
            {{--<a class="btn btn-primary" href="/admin/user/create">افزودن کاربر</a>--}}
        </div>
        <div class="col-md-6 text-right">
            <h4>لیست کاربران </h4>
        </div>
    </div>
    <hr>
    <table id="dataTable" class="table table-striped table-bordered dataTable" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>عملیات</th>
            <th>نقش</th>
            <th>ایمیل</th>
            <th>نام کاربر</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>عملیات</th>
            <th>نقش</th>
            <th>ایمیل</th>
            <th>نام کاربر</th>
        </tr>
        </tfoot>
        <tbody>
        @foreach($users as $user)
        <tr>
            <td>
                <a href="/admin/user/edit/id/{{ $user->id }}">ویرایش</a>
            </td>
            <td>{{ $user->role->name or 'بدون نقش' }}</td>
            <td>{{ $user->email }}</td>
            <td>@if($user->is_active == 0) <del>{{ $user->name }}</del> @else {{ $user->name }} @endif</td>
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