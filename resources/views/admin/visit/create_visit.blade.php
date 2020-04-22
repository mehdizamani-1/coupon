@extends('layouts.operator_master')

@section('title')
    ثبت ویزیت
@endsection
@section('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <!-------------------- Main Content ------------------>

    <div class="content-wrapper">

        <div class="card card-shadow h-100">
            <div class="card-header border-0">
                <h2 class="h6 py-3 mb-0 font-weight-bold card-title">ثبت ویزیت </h2>
                <p>زمان هر ویزیت: {{ $doctorTimeWork->visit_time }} دقیقه </p>
            </div>
            <div class="card-body">
                @include('includes.info-box')
                <form id="upload_form" action="{{ route('admin.visit.create.post') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-row">
                        <input type="hidden" id="visit_time" value="{{ $doctorTimeWork->visit_time }}" name="visit_time">
                        <div class="form-group col-xl-6 col-12">
                            <label for="exampleInputUsername1">نام کامل</label>
                            <input type="text" class="form-control" value="{{ Request::old('fullname') }}" name="fullname" id="exampleInputUsername1" placeholder="نام ...">
                        </div>
                        <div class="form-group col-xl-6 col-12">
                            <label for="exampleInputUsername1">موبایل کاربر</label>
                            <input type="text" class="form-control" value="{{ Request::old('mobile') }}" name="mobile" id="exampleInputUsername1" placeholder="موبایل">
                        </div>
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
                        <div class="form-group col-12">
                            <label for="exampleInputUsername1">مختصری از مشکل بیمار</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>



                    </div>

                    <button type="submit" class="btn btn-primary px-5 py-2 mt-4">ثبت</button>
                </form>
            </div>
        </div>

    </div>
    <!---------------- remove-post-modal --------------->

@endsection
@section('script')
    <script>
        $.ajaxSetup({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {

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