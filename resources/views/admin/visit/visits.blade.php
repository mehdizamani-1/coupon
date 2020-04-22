@extends('layouts.operator_master')

@section('title')
    ویزیت ها
@endsection
@section('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

    <div class="content-wrapper">

        <div class="card card-shadow h-100">
            <div class="card-header border-0">
                <h2 class="h6 py-3 mb-0 font-weight-bold card-title">ویزیت ها</h2>
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
                            <th>هزینه</th>
                            <th>توضیحات</th>
                            <th>ویزیت</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>نام کاربر</th>
                            <th>تاریخ </th>
                            <th> زمان</th>
                            <th>هزینه</th>
                            <th>توضیحات</th>
                            <th>ویزیت</th>
                        </tr>
                        </tfoot>
                        <tbody class="attach_requests">

                        @if( isset($visits) )
                            <?php $i = 1;?>
                            @foreach( $visits as $visit )
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $visit['full_name'] }}</td>
                                    <td>{{ gregorian_to_jalali_string($visit['visit_date'], false) }}</td>
                                    <td>{{ $visit['visit_time'] }}</td>
                                    <td>{{ $visit['price'] }}</td>
                                    <td>{{ $visit['description'] }}</td>
                                    <td>@if( $visit['visit'] )<i class="fa fa-check-square-o text-info " title="ویزیت شده" data-id="{{ $visit['id'] }}"></i>@else <i data-id="{{ $visit['id'] }}" title="ویزیت نشده" style="cursor: pointer" class="fa fa-list text-info text-center toggle-row"></i> @endif @if( $visit['visit'] == 0 )<i class="fa fa-edit text-info edit-row" style="cursor: pointer" title="ویرایش" data-id="{{ $visit['id'] }}" data-user-id="{{ $visit['user_id'] }}"></i> @endif </td>
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
    <div class="modal fade" id="toggle-post-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">وضعیت ویزیت
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group col-12"  id="message-div">
                        <label for="exampleInputUsername1">توضیحات نسخه (اجباری)</label>
                        <textarea class="form-control" id="prescription" rows="3"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger float-right" data-dismiss="modal">بستن</button>
                    <button type="button" id="modal-toggle-btn" class="btn btn-outline-primary">ذخیره</button>
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
                    <p>زمان هر ویزیت: {{ $doctorTimeWork->visit_time }} دقیقه </p>
                    <form action="<?=route('admin.visit.edit')?>" method="post">
                        <input type="hidden" value="<?=csrf_token()?>" name="_token">
                        <input type="hidden" id="visit_id" value="" name="visit_id">
                        <input type="hidden" id="user_id" value="" name="user_id">
                        <input type="hidden" id="visit_time" value="{{ $doctorTimeWork->visit_time }}" name="visit_time">
                        <div class="modal-body">

                            <div class="form-row">
                                <div class="form-group col-xl-4 col-sm-4">
                                    <label for="exampleInputUsername1"> تاریخ ویزیت</label>
                                    <input name="date" class="range-date-example datepicker-style w-100 form-control">
                                </div>
                                <div class="form-group col-xl-4 col-sm-4">
                                    <label for="exampleInputUsername1">ساعت ویزیت</label>
                                    <select onchange="getCalculate(this)" id="hour_change" type="text" class="form-control"  >
                                        <option value="">انتخاب نمایید</option>
                                        @for( $j = $DayTimes[0]; $j <= $DayTimes[1]; $j++ )
                                            <option value="{{ $j }}">{{ $j }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group col-xl-4 col-sm-4">
                                    <label for="exampleInputUsername1">بازه زمانی</label>
                                    <select name="time" id="hour_fix" type="text" class="form-control"  >
                                        <option value="">انتخاب نمایید</option>

                                    </select>
                                </div>


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
                var user_id = button.data('user-id');
                if( user_id != '' )
                    $('#user_id').val(user_id);
                if( visit_id != '' )
                    $('#visit_id').val(visit_id);
            });

            // ---------- modal function-----------
            $('.toggle-row').click(function () {
                var data = $(this);
                $('#toggle-post-modal').modal('show', data);
            });
            $('#toggle-post-modal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var visit_id = button.data('id');

                $(this).find('#modal-toggle-btn').attr('data-visit-id', visit_id);
            });
            $('#modal-toggle-btn').click(function () {
                var visit_id = $(this).attr('data-visit-id');
                var prescription = $('#prescription').val();
                $.post('/admin/visit/accept', {
                    visit_id: visit_id,
                    prescription: prescription
                }, function (Res) {
                    console.log(Res);
                    $('#toggle-post-modal').modal('toggle');
                    if (Res['status_number'] === '1') {

                        var rows = $('.toggle-row');
                        for( var j = 0; j < rows.length; j++){
                            var id_attach = rows[j].getAttribute('data-id');
                            if (id_attach == visit_id) {
                                rows[j].className = rows[j].className.replace(/\bfa-list\b/g, "fa-check-square-o");
                                // rows[j].className = rows[j].className.replace(/\btext-danger\b/g, "text-info");
                            }
                        }
                    } else {
                        alert(Res['message']);
                    }
                });
            });

        });
        function getCalculate(element) {
            var hour = element.value;
            var visit_time = parseInt($('#visit_time').val());
            var round = 60/visit_time;

            var option = hour + ':' + '00';
            $('#hour_fix').html('');
            $('#hour_fix').append(`<option value="${option}">
                                       ${option}
                                  </option>`);
            for( var i = visit_time; i < round * visit_time; i+=visit_time ){

                option = hour + ':' + i;
                $('#hour_fix').append(`<option value="${option}">
                                       ${option}
                                  </option>`);
            }

        }
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
        date = $(".range-date-example").persianDatepicker({
            format: 'YYYY/MM/DD',
            autoClose: true,
            persianDigit : false,
            persianNumbers: !0,
            onSelect: function (unix) {
                if (date && date.options && date.options.maxDate != unix) {
                    var cachedValue = date.getState().selected.unixDate;

                    // date.options = {
                    //     maxDate: unix
                    // };
                    if (date.touched) {
                        date.setDate(cachedValue);
                    }
                    var er = date.setDate(cachedValue);
                    var year = er['state']['view']['year'];
                    var month = er['state']['view']['month'];
                    var day = er['state']['view']['date'];

                    var date_ = year + '/' + month + '/' + day;
                    console.log(date_);

                    $.post('/admin/visits/timeworks', {
                        date: date_,
                    }, function (Res) {

                        console.log(Res);
                        $('#hour_change').html('').append(Res);

                    });
                }
            }
        });
    </script>
@endsection