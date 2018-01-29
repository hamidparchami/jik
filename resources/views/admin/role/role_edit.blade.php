@extends('layouts.app')

@section('header_links')
    <link href="/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.3/themes/default/style.min.css" />
@endsection


@section('content')
<div class="container main-container">
    @if (count($errors) > 0)
        <div class="alert alert-danger rtl">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form id="form1" method="post">
        <div class="row">
            <div class="col-md-12 text-right">
                <div class="panel panel-default">
                    <div class="panel-heading">ویرایش نقش</div>
                    <div class="panel-body">
                        {{ csrf_field() }}
                        <div class="row form-row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <input name="name" type="text" class="form-control rtl" value="{{ (old('name')) ?: $role->name }}">
                            </div>
                            <div class="col-md-4">نام نقش</div>
                        </div>

                        <div class="row form-row">
                            <div class="col-md-8">
                                <div style="margin-bottom: 10px;"><strong>تمامی دسترسی ها <input type="checkbox" id="check_all" style="cursor: pointer"></strong></div>

                                <div id="container" class="rtl">
                                    @foreach($urls as $url)
                                    <ul>
                                        <li class="jstree-checked" id="{{ $url->id }}"><strong>{{ $url->title }}</strong>
                                            <ul>
                                                @foreach($url->children as $child)
                                                <li id="{{ $child->id }}" @if(in_array($child->id, $allowed_urls)) data-jstree='{ "selected" : true, "opened" : true }' @endif>{{ $child->title }}</li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    </ul>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-4">سطوح دسترسی</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="action_buttons">
            <div class="col-md-12 text-right">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2 col-sm-4 col-xs-4 text-left">

                            </div>
                            <div class="col-md-9 col-sm-4 col-xs-4">
                                <a href="/admin/role/manage" class="btn btn-warning">بازگشت</a>
                            </div>
                            <div class="col-md-1 col-sm-4 col-xs-4 text-left">
                                <button type="submit" id="submit" class="btn btn-success">ذخیره</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="allowed_urls" id="allowed_urls" />
    </form>
</div>
@endsection

@section('footer_scripts')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.3/jstree.min.js"></script>

<script>
    $(function() {
        $('#container').jstree({
            "plugins" : ["checkbox"]
        });

        $("#check_all").change(function() {
            if(this.checked) {
                $("#container").jstree('open_all');
                $("#container").jstree("check_all");
            } else {
                $("#container").jstree("uncheck_all");
            }
        });

        $('#form1').submit(function () {
            var selectedElmsIds = [];
            var selectedElms = $('#container').jstree("get_selected", true);
            $.each(selectedElms, function() {
                selectedElmsIds.push(this.id);
            });
            //set data into hidden field
            $('#allowed_urls').val(selectedElmsIds);
        });
    });
</script>
@endsection