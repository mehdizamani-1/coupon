@extends('layouts.operator_master')

@section('title')
    پرونده ها
@endsection
@section('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

    <div class="content-wrapper">

        <div class="card card-shadow h-100">
            <div class="card-header border-0">
                <h2 class="h6 py-3 mb-0 font-weight-bold card-title">پرونده ها</h2>
            </div>

            <div class="card-body">
                @include('includes.info-box')
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-8 col-md-9">
                        <form  action="{{ route('admin.visits') }}" method="get">
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
                <div class="table-responsive">
                    <table id="data_table" class="table table-bordered table-striped" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام کاربر</th>
                            <th>تاریخ </th>
                            <th> زمان</th>
                            <th>توضیحات</th>
                            <th>نسخه</th>
                            <th>تاریخ ثبت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>نام کاربر</th>
                            <th>تاریخ </th>
                            <th> زمان</th>
                            <th>توضیحات</th>
                            <th>نسخه</th>
                            <th>تاریخ ثبت</th>
                            <th>عملیات</th>
                        </tr>
                        </tfoot>
                        <tbody class="attach_requests">

                        @if( isset($visits) )
                            <?php $i = 1;?>
                            @foreach( $visits as $visit )
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $visit['full_name'] }}</td>
                                    <td>{{ gregorian_to_jalali_string($visit['date'], false) }}</td>
                                    <td>{{ $visit['time'] }}</td>
                                    <td>{{ $visit['comment'] }}</td>
                                    <td>{{ $visit['prescription'] }}</td>
                                    <td>{{ gregorian_to_jalali_pro($visit['created_at'], true) }}</td>
                                    <td><i class="fa fa-edit text-info edit-row" style="cursor: pointer" title="ویرایش" data-id="{{ $visit['id'] }}" data-prescription="{{ $visit['prescription'] }}"></i> </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="row justify-content-center pt-4">

                <div class="pagination-box ">
                    {{ $visits->links() }}
                </div>

            </div>

        </div>
    </div>
    <div class="modal fade" id="edit-post-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ویرایش
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?=route('admin.visits.prescription.edit')?>" method="post">
                        <input type="hidden" value="<?=csrf_token()?>" name="_token">
                        <input type="hidden" id="visit_prescription_id" value="" name="visit_prescription_id">
                        <div class="modal-body">

                            <div class="form-group col-12"  id="message-div">
                                <label for="exampleInputUsername1">توضیحات نسخه (اجباری)</label>
                                <textarea class="form-control" name="prescription" id="prescription" rows="3"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger float-right" data-dismiss="modal">بستن</button>
                            <button type="submit" id="modal-btn" class="btn btn-outline-primary">ذخیره</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!------------------- end change modal -------------------->
@endsection
@section('script')
    <script>
        $.ajaxSetup({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {

            $('.edit-row').click(function () {
                var data = $(this);
                $('#edit-post-modal').modal('show', data);
            });
            $('#edit-post-modal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var visit_id = button.data('id');
                var prescription = button.data('prescription');
                if (prescription != '')
                    $('#prescription').val(prescription);
                if (visit_id != '')
                    $('#visit_prescription_id').val(visit_id);
            });
        });
        //----------end modal function---------
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