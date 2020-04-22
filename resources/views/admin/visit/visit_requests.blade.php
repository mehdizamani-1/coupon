@extends('layouts.operator_master')

@section('title')
    درخواست ها
@endsection
@section('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

    <div class="content-wrapper">

        <div class="card card-shadow h-100">
            <div class="card-header border-0">
                <h2 class="h6 py-3 mb-0 font-weight-bold card-title">درخواست ها</h2>
            </div>

            <div class="card-body">
                @include('includes.info-box')
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-8 col-md-9">
                        <form  action="{{ route('admin.visit.requests') }}" method="get">
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
                            <th> درخواست</th>
                            <th>تاریخ درخواست از</th>
                            <th>تا تاریخ</th>
                            <th>زمان</th>
                            <th>مشکل بیمار</th>
                            <th>تاریخ ثبت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>نام کاربر</th>
                            <th> درخواست</th>
                            <th>تاریخ درخواست از</th>
                            <th>تا تاریخ</th>
                            <th>زمان</th>
                            <th>مشکل بیمار</th>
                            <th>تاریخ ثبت</th>
                            <th>عملیات</th>
                        </tr>
                        </tfoot>
                        <tbody id="attach_requests">

                        @if( isset($requests) )
                            <?php $i = 1;?>
                            @foreach( $requests as $request )
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $request['full_name'] }}</td>
                                    <td>@if( $request['doctor_id'] == 0 ) عمومی @else شخصی @endif  </td>
                                    <td>@if( $request['date_start'] != '0000-00-00' ){{ gregorian_to_jalali_string($request['date_start'], false) }} @endif</td>
                                    <td>@if( $request['date_end'] != '0000-00-00' ){{ gregorian_to_jalali_string($request['date_end'], false) }}@endif</td>
                                    <td>{{ $request['time_start'] . '  ' . $request['time_end']  }}</td>
                                    <td>{{ $request['description'] }}</td>
                                    <td>{{ gregorian_to_jalali_pro($request['created_at'], true) }}</td>
                                    <td><i class="fa fa-check-square-o text-info accept-row" style="cursor: pointer" title="قبول" data-id="{{ $request['id'] }}" data-user-id="{{ $request['user_id'] }}"></i></td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="accept-post-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">آیا میخواهید قبول کنید؟
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>زمان هر ویزیت: {{ $doctorTimeWork->visit_time }} دقیقه </p>
                    <form action="<?=route('admin.visit.request.accept')?>" method="post">
                        <input type="hidden" value="<?=csrf_token()?>" name="_token">
                        <input type="hidden" id="request_id" value="" name="request_id">
                        <input type="hidden" id="user_id" value="" name="user_id">
                        <input type="hidden" id="visit_time" value="{{ $doctorTimeWork->visit_time }}" name="visit_time">
                        <div class="modal-body">

                            <div class="form-row">
                                <div class="form-group col-xl-4 col-sm-4">
                                    <label for="exampleInputUsername1"> تاریخ ویزیت</label>
                                    <input name="date" id="date_visit" class="range-date-example datepicker-style w-100 form-control">
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
        function acceptRow(user_id, request_id){

            $('#accept-post-modal').modal('show');
            document.getElementById('user_id').value = parseInt(user_id);
            document.getElementById('request_id').value = parseInt(request_id);
        }
        $(document).ready(function() {

            setInterval(function(){
                $.post('/admin/visit/requests/ajax', {
                    status: '1',
                }, function (Res) {

                    console.log(Res);
                    $('#attach_requests').html('').append(Res);

                });
            }, 15000);
            // ---------- modal function-----------

            $('.accept-row').click(function () {
                var data = $(this);
                $('#accept-post-modal').modal('show', data);
            });
            $('#accept-post-modal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var request_id = button.data('id');
                var user_id = button.data('user-id');
                if( user_id != '' )
                    $('#user_id').val(user_id);
                if( request_id != '' )
                    $('#request_id').val(request_id);
            });


        });
        function getCalculate(element) {
            var hour = element.value;
            var visit_time = parseInt($('#visit_time').val());
            var date_visit = $('#date_visit').val();
            var round = 60/visit_time;
            var times_ = '';
            $.post('/admin/visit/check/requests/ajax', {
                hour: hour,
                visit_time: visit_time,
                date_visit: date_visit,
            }, function (Res) {


                times_ = Res['times'];
                console.log(times_);

                var option = hour + ':' + '00';
                $('#hour_fix').html('');
                $('#hour_fix').append(`<option  value="">انتخاب نمایید...</option>`);
                var color = 'transparent';
                var disabled = '';
                if( times_.includes(option) ){
                    color = '#ff9999';
                    disabled = 'disabled';
                }

                $('#hour_fix').append(`<option style="background-color: `+ color +`" `+disabled+` value="${option}">
                                       ${option}
                                  </option>`);
                for( var i = visit_time; i < round * visit_time; i+=visit_time ){
                    color = 'transparent';
                    disabled = '';
                    option = hour + ':' + i;
                    if( times_.includes(option) ){
                        color = '#ff9999';
                        disabled = 'disabled';
                    }

                    // alert(times_.from(option));
                    $('#hour_fix').append(`<option style="background-color: `+ color +`" `+disabled+` value="${option}">
                                       ${option}
                                  </option>`);
                }
            });


        }
        //----------end modal function---------
        var to, from, date;
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