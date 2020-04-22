@extends('layouts.operator_master')

@section('title')
    کارمندان
@endsection
@section('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <div class="content-wrapper">

        <div class="card card-shadow h-100">
            <div class="card-header border-0">
                <h2 class="h6 py-3 mb-0 font-weight-bold card-title">کارمندان</h2>
            </div>
            <div class="card-body">
            @include('includes.info-box')
            <!-- change 6/9/98 -->
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-8 col-md-9">
                        <form  action="{{ route('panel.accounts.show') }}" method="get">
                            <div class="form-row">
                                <div class="form-group col-xl-4 col-sm-4">
                                    <label for="exampleInputUsername1"> تاریخ شروع</label>
                                    <input @if(isset($_GET['from_date'])) value="{{ $_GET['from_date'] }}" @endif name="from_date" class="range-from-example datepicker-style w-100 form-control">
                                </div>
                                <div class="form-group col-xl-4 col-sm-4">
                                    <label for="exampleInputUsername1"> تاریخ پایان</label>
                                    <input @if(isset($_GET['to_date'])) value="{{ $_GET['to_date'] }}" @endif name="to_date" class="range-to-example datepicker-style w-100 form-control">
                                </div>
                                <div class="col-xl-2 col-sm-2">
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
                                <a style="cursor: pointer" onclick="toExcel('operators', 'content')" class="text-success" title="excel"> <i class="fa fa-file-excel-o fa-2x px-1" aria-hidden="true"></i></a>
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
                            <th>موبایل</th>
                            <th>تصویر</th>
                            <th>تاریخ ثبت</th>
                            <th>عملیات</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>موبایل</th>
                            <th>تصویر</th>
                            <th>تاریخ ثبت</th>
                            <th>عملیات</th>
                        </tr>
                        </tfoot>
                        <tbody>

                        @if( isset($accounts) )
                            <?php $i = 1; ?>
                            @foreach( $accounts as $account )
                                <tr>

                                    <td>{{ $i++ }}</td>
                                    <td>{{ $account['nickname'] }}</td>
                                    <td>{{ $account['mobile'] }}</td>
                                    <td><img data-src="{{ $url }}/{{ $account['avatar'] }}" height="40px" style="cursor: pointer;" src="{{ $url }}/{{ $account['avatar'] }}" alt="" class="ct-img"></td>
                                    <td>{{ gregorian_to_jalali_pro($account['created_at'], true) }}</td>
                                    <td>@if( $account['active'] )<i class="fa fa-check-square-o text-info toggle-row" style="cursor: pointer" title="فعال" data-id="{{ $account['id'] }}"></i>@else <i class="fa fa-times text-danger toggle-row" style="cursor: pointer" title="غیرفعال" data-id="{{ $account['id'] }}"></i> @endif</td>

                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade bd-example-modal-sm" id="img-modal"  tabindex="-1" role="dialog"
         aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">
                        تصویر</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="" style="width: 100%; height: 300px"  alt="" class="ct-img-mod">
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



@endsection
@section('script')
    <script>
        $.ajaxSetup({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('.ct-img').click(function(){
                var data = $(this);
                $('#img-modal').modal('show',data);
            });
            $('#img-modal').on('show.bs.modal', function (event) {
                var img = $(event.relatedTarget);
                var src = img.data('src');
                $(this).find('.ct-img-mod').attr('src',src);

            });
            // ---------- modal function-----------
            $('.toggle-row').click(function () {
                var data = $(this);
                $('#toggle-post-modal').modal('show', data);
            });
            $('#toggle-post-modal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var depot_id = button.data('id');
                $(this).find('#modal-toggle-btn').attr('data-account-id', depot_id);
            });
            $('#modal-toggle-btn').click(function () {
                var account_id = $(this).attr('data-account-id');
                $.post('/admin/accounts/toggle', {
                    account_id: account_id
                }, function (Res) {
                    if (Res['status_number'] === '1') {
                        var rows = $('.toggle-row');
                        for( var j = 0; j < rows.length; j++){
                            var id_attach = rows[j].getAttribute('data-id');
                            if (id_attach == account_id) {
                                if( Res['active'] == 1 ){
                                    rows[j].className = rows[j].className.replace(/\bfa-times\b/g, "fa-check-square-o");
                                    rows[j].className = rows[j].className.replace(/\btext-danger\b/g, "text-info");
                                } else{
                                    rows[j].className = rows[j].className.replace(/\bfa-check-square-o\b/g, "fa-times");
                                    rows[j].className = rows[j].className.replace(/\btext-info\b/g, "text-danger");
                                }
                            }
                        }
                    } else {
                        alert(Res['message']);
                    }
                });
            });
            //----------end modal function---------

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
    </script>
@endsection