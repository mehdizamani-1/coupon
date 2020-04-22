
@extends('layouts.operator_master')

@section('title')
    نظرات
@endsection
@section('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')


    <div class="content-wrapper">

        <div class="card card-shadow h-100">
            <div class="card-header border-0">
                <h2 class="h6 py-3 mb-0 font-weight-bold card-title">نظرات کاربران</h2>
            </div>
            <div class="card-body">
            @include('includes.info-box')
            <!-- change 6/9/98 -->
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-8 col-md-9">
                        <form action="{{ route('panel.comments') }}" method="get">
                            <div class="form-row">
                                <div class="form-group col-xl-3 col-sm-4">
                                    <label for="exampleInputUsername1">از تاریخ</label>
                                    <input @if(isset($_GET['from_date'])) value="{{ $_GET['from_date'] }}" @endif name="from_date" class="range-from-example datepicker-style w-100 form-control">
                                </div>
                                <div class="form-group col-xl-3 col-sm-4">
                                    <label for="exampleInputUsername1">تا تاریخ</label>
                                    <input @if(isset($_GET['to_date'])) value="{{ $_GET['to_date'] }}" @endif name="to_date" class="range-to-example datepicker-style w-100 form-control">
                                </div>

                                <div class="col-xl-3 col-sm-2">
                                    <button type="submit" class="btn btn-primary py-3 mt-4">جستجو</button>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 col-md-3 text-left">
                        <div class="form-group">
                            <label for="exampleInputUsername1"> خروجی
                            </label>
                            <div class="">
                                <a style="cursor: pointer" onclick="toExcel('projects', 'content')" class="text-success" title="excel"> <i class="fa fa-file-excel-o fa-2x px-1" aria-hidden="true"></i></a>
                                <a style="cursor: pointer" class="text-success" id="json" title="json"> <i class=" fa fa-file fa-2x px-1" aria-hidden="true"></i></a>
                                <a style="cursor: pointer" class="text-success" id="csv" title="csv"> <i class=" fa fa-file fa-2x px-1" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / change 6/9/98 -->
                <div class="table-responsive">
                    <table id="data_table" class="table table-bordered table-striped table2excel" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>نظر</th>
                            <th>جواب</th>
                            <th>تاریخ ثبت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>نظر</th>
                            <th>جواب</th>
                            <th>تاریخ ثبت</th>
                            <th>عملیات</th>
                        </tr>
                        </tfoot>
                        <tbody>

                        @if( isset($comments) )
                            <?php $i = 1;

                            ?>
                            @foreach( $comments as $comment )
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $comment['full_name'] }}</td>
                                    <td>{{ $comment['comment'] }}</td>
                                    <td>@if( $comment['reply'] != '' ) {{ $comment['reply'] }} @else  <button type="button" class="btn btn-primary reply" data-toggle="modal" data-id="{{ $comment['id'] }}" >جواب</button> @endif</td>
                                    <td>{{ gregorian_to_jalali_pro($comment['created_at'], true) }}</td>
                                    <td>@if( $comment['active'] )<span style="cursor: pointer" class="badge badge-success toggle-row" title="فعال" data-id="{{ $comment['id'] }}">فعال</span>@else <span style="cursor: pointer" class="badge badge-danger toggle-row" title="غیرفعال" data-id="{{ $comment['id'] }}">غیر فعال</span> @endif<i style="cursor: pointer" data-id="{{ $comment['id'] }}" class="fa fa-times text-danger text-center p-3 delete-row"></i></td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row justify-content-center pt-4">
                <div class="pagination-box ">

                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="remove-post-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">آیا میخواهید حذف کنید؟
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn  btn-outline-danger" data-dismiss="modal">بستن</button>
                    <button type="button" id="modal-delete-btn" data-dismiss="modal" class="btn  btn-outline-primary">حذف</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="toggle-post-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">آیا میخواهید وضعیت تغییر کنید؟
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn  btn-outline-danger" data-dismiss="modal">بستن</button>
                    <button type="button" id="modal-toggle-btn" data-dismiss="modal" class="btn  btn-outline-primary">ذخیره</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">  جواب</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="post" action="{{ route('panel.comment.reply') }}">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token">
                    <div class="modal-body">

                        <div class="form-row">

                            <div class="form-group col-12">
                                <label for="exampleInputUsername1">توضیحات مختصر</label>
                                <textarea class="form-control" name="reply" id="exampleFormControlTextarea2" rows="3"></textarea>
                                <input type="hidden" name="comment_id" id="comment_id_reply">
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger float-right" data-dismiss="modal">بستن</button>
                        <button type="submit" class="btn btn-outline-primary">ذخیره</button>
                    </div>
                </form>

            </div>

        </div>
    </div>




@endsection
@section('script')
    <script>

        $.ajaxSetup({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $('.reply').on('click', function (event) {
                var data = $(this);
                $('.bd-example-modal-sm').modal('show', data);

            });
            $('.bd-example-modal-sm').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var comment_id = button.data('id');
                $('#comment_id_reply').val(comment_id);
            });
            ///////
            $('.delete-row').click(function () {
                var data = $(this);
                $('#remove-post-modal').modal('show', data);
            });
            $('#remove-post-modal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var comment_id = button.data('id');
                $(this).find('#modal-delete-btn').attr('data-comment-id', comment_id);
            });
            $('#modal-delete-btn').click(function () {
                var comment_id = $(this).attr('data-comment-id');
                $.post('/admin/comment/remove', {
                    comment_id: comment_id
                }, function (Res) {
                    console.log(Res);
                    if (Res['status'] === 'ok') {
                        var rows = $('.delete-row');
                        for (var j = 0; j < rows.length; j++) {
                            var id_attach = rows[j].getAttribute('data-id');
                            if (id_attach == comment_id) {
                                rows[j].parentNode.parentNode.remove();
                            }
                        }
                    } else {
                        alert(Res['message']);
                    }
                });

            });

            $('.toggle-row').click(function () {
                _this = $(this);
                var comment_id = $(this).attr('data-id');
                $.post('/admin/comment/toggle', {
                    comment_id: comment_id
                }, function (Res) {
                    console.log(Res);
                    if (Res['status'] === 'ok') {

                        if( Res['active'] == 1 ){
                            _this.addClass('badge-success').removeClass('badge-danger');
                            _this.html('فعال');
                        } else{
                            _this.addClass('badge-danger').removeClass('badge-success');
                            _this.html('غیر فعال');
                        }

                    } else {
                        alert(Res['message']);
                    }
                });

            });
            $('#toggle-post-modal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var comment_id = button.data('id');
                $(this).find('#modal-toggle-btn').attr('data-comment-id', comment_id);
            });
            $('#modal-toggle-btn').click(function () {

            });



        });
        var to, from;
        to = $(".range-to-example").persianDatepicker({
            format: 'YYYY/MM/DD',
            autoClose: true,
            persianDigit : false,
            persianNumbers: !0,
            onSelect: function (unix) {
                to.touched = true;
                if (from && from.options && from.options.maxDate != unix) {
                    var cachedValue = from.getState().selected.unixDate;

                    from.options = {
                        maxDate: unix
                    };
                    if (from.touched) {
                        from.setDate(cachedValue);
                    }

                }
            }
        });
        from = $(".range-from-example").persianDatepicker({
            format: 'YYYY/MM/DD',
            autoClose: true,
            persianDigit : false,
            persianNumbers: !0,
            onSelect: function (unix) {
                from.touched = true;
                if (to && to.options && to.options.minDate != unix) {
                    var cachedValue = to.getState().selected.unixDate;

                    if (to.touched) {
                        to.setDate(cachedValue);
                    }

                }
            }
        });
        //----------end modal function---------
    </script>
@endsection