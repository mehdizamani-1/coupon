@extends('layouts.operator_master')

@section('title')
    ثبت / ویرایش
@endsection
@section('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">




    <style>
        a.icon-close {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.3);
            width: 50px;
            border: 1px solid #fff;
            color: #fff;
            border-radius: 50%;
            height: 50px;
            font-size: 20px;
            line-height: 50px;
            text-align: center;
        }

        a.icon-close:hover {
            background: rgb(0, 0, 0);
        }

    </style>
@endsection
@section('content')
    <!-------------------- Main Content ------------------>


    <div class="content-wrapper">

        <div class="card card-shadow h-100">
            <div class="card-header border-0">
                <h2 class="h6 py-3 mb-0 font-weight-bold card-title">افزودن/ویرایش وقت ویزیت</h2>
            </div>
            @include('includes.info-box')
            <div class="card-body">

                <form id="upload_form" action="{{ route('admin.time.post') }}"  method="post" class="needs-validation" novalidate>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-row">
                        <div class="tab-pane p-3 form-group col-12" id="atri" role="tabpanel">
                            <div class="table-responsive table-cust-res">
                                <table class="table table-striped" id="tbl-list">
                                    <thead>
                                    <tr>
                                        <th scope="col">روز هفته</th>
                                        <th scope="col">ساعت های کاری</th>
                                        <th class="text-left pb-0">
                                            <div class="btn-add-row text-primary"><i class="fa fa-plus text-green fa-2x mt-3"></i></div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="tbody-atr">
                                    <?php
                                        if( isset($visitTime) ){
                                            $day_works = explode(',', $visitTime->day_works);
                                            $day_times = explode(',', $visitTime->time_works);
                                            $i = 0;
                                            foreach ($day_works as $day_work){
                                    ?>
                                    <tr class="tr-atr">

                                        <th class="" style="min-width: 400px!important;">
                                            <select name="day_works[]" class="form-control" id="">
                                                <option @if( $day_work == '0' ) selected @endif value="0">شنبه</option>
                                                <option @if( $day_work == '1' ) selected @endif value="1">یکشنبه</option>
                                                <option @if( $day_work == '2' ) selected @endif value="2">دوشنبه</option>
                                                <option @if( $day_work == '3' ) selected @endif value="3">سه شنبه</option>
                                                <option @if( $day_work == '4' ) selected @endif value="4">چهار شنبه</option>
                                                <option @if( $day_work == '5' ) selected @endif value="5">پنج شنبه</option>
                                                <option @if( $day_work == '6' ) selected @endif value="6">جمعه</option>
                                            </select>
                                        </th>
                                        <td class="col-6"> <input type="text" value="{{ $day_times[$i] }}" name="time_works[]" class="form-control" id="exampleInputUsername1" placeholder="8-16"></td>

                                        <td class="text-left col-md-2">
                                            <div class="delete-atr"><i class="fa fa-times text-danger fa-2x mt-3"></i>
                                            </div>
                                        </td>
                                    </tr>

                                    <?php
                                       $i++;
                                        }

                                    }


                                    ?>


                                    <tr class="tr-atr">

                                        <th class="" style="min-width: 400px!important;">
                                            <select name="day_works[]" class="form-control" id="">
                                                <option value="0">شنبه</option>
                                                <option value="1">یکشنبه</option>
                                                <option value="2">دوشنبه</option>
                                                <option value="3">سه شنبه</option>
                                                <option value="4">چهار شنبه</option>
                                                <option value="5">پنج شنبه</option>
                                                <option value="6">جمعه</option>
                                            </select>
                                        </th>
                                        <td class="col-6"> <input type="text" name="time_works[]" class="form-control" id="exampleInputUsername1" placeholder="8-16"></td>

                                        <td class="text-left col-md-2">
                                            <div class="delete-atr"><i class="fa fa-times text-danger fa-2x mt-3"></i>
                                            </div>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <!-- / change 6/9/98 -->
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-xl-4 col-12">
                            <label for="exampleInputUsername1">زمان هر ویزیت</label>
                            <input type="number" class="form-control" value="{{ Request::old('visit_time')?Request::old('visit_time'):( isset($visitTime) )?$visitTime->visit_time:'' }}" name="visit_time" id="exampleInputUsername1" placeholder="دقیقه" required>
                            <div class="invalid-feedback">
                                لطفا زمان ویزیت را وارد نمایید
                            </div>
                            <div class="valid-feedback">
                                صحیح است
                            </div>
                        </div>
                        <div class="form-group col-xl-4 col-12">
                            <label for="exampleInputUsername1">برنامه برای چند روز</label>
                            <input type="number" class="form-control" value="{{ Request::old('visit_for_days')?Request::old('visit_for_days'):( isset($visitTime) )?$visitTime->visit_for_days:'' }}" name="visit_for_days" id="exampleInputUsername1" placeholder="30 روز" required>
                            <div class="invalid-feedback">
                                لطفا تعداد روز را وارد نمایید
                            </div>
                            <div class="valid-feedback">
                                صحیح است
                            </div>
                        </div>
                        <div class="form-group col-xl-4 col-12">
                            <label for="exampleInputUsername1">تاریخ انقضاء برنامه ویزیت</label>
                            <input type="text" class="form-control" value="{{ ( isset($visitTime) )?gregorian_to_jalali_string($visitTime->end_date, false):'' }}" disabled id="exampleInputUsername1">

                        </div>



                    </div>


                    <button type="submit" class="btn btn-primary px-5 py-2 mt-4">ثبت/ویرایش</button>
                </form>
            </div>
        </div>

    </div>


@endsection
@section('script')
    <script>
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName(
                    'needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(
                    forms,
                    function (form) {
                        form.addEventListener('submit',
                            function (event) {
                                if (form
                                        .checkValidity() ===
                                    false) {
                                    event
                                        .preventDefault();
                                    event
                                        .stopPropagation();
                                }
                                form.classList.add(
                                    'was-validated'
                                );
                            }, false);
                    });
            }, false);
        })();
        $.ajaxSetup({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var i = 0;
        $(document).ready(function() {
            $(".btn-add-row").click(function() {
                var tr = $('#tbl-list tr').eq(1).clone(true);
                // tr.find('.btn-del-row').css('display', 'inline-block');
                tr.find('input[type="text"]').val('');
                // tr.find('select option:selected').next().attr('selected', 'selected');

                $('#tbl-list').append(tr);

            });



            $('.btn-del-row').click(function() {
                $(this).parent().parent().remove();
            });



        });





    </script>
@endsection