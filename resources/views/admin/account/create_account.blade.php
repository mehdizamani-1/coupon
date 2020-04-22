@extends('layouts.operator_master')

@section('title')
    ثبت کارمند
@endsection
@section('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <!-------------------- Main Content ------------------>

    <div class="content-wrapper">

        <div class="card card-shadow h-100">
            <div class="card-header border-0">
                <h2 class="h6 py-3 mb-0 font-weight-bold card-title">ثبت کارمند </h2>
            </div>
            <div class="card-body">
                @include('includes.info-box')
                <form id="upload_form" action="{{ route('panel.accounts.account.create.post') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-row">
                        <div class="col-xl-9 col-md-8">
                            <div class="form-row">
                                <div class="form-group col-xl-4 col-12">
                                    <label for="exampleInputUsername1">نام کامل</label>
                                    <input type="text" class="form-control" value="{{ Request::old('nickname') }}" name="nickname" id="exampleInputUsername1" placeholder="نام ...">
                                </div>
                                <div class="form-group col-xl-4 col-12">
                                    <label for="exampleInputUsername1">موبایل</label>
                                    <input type="text" class="form-control" value="{{ Request::old('mobile') }}" name="mobile" id="exampleInputUsername1" placeholder="موبایل">
                                </div>
                                <div class="form-group col-xl-4 col-12">
                                    <label for="exampleInputUsername1">کد ملی</label>
                                    <input type="text" class="form-control" value="{{ Request::old('national_id') }}" name="national_id" id="exampleInputUsername1" placeholder="10 رقمی">
                                </div>



                            </div>
                        </div>
                        <div class="col-xl-3 col-md-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">تصویر</label>
                                <input type="file" onchange="encodeImageFileAsURL(this)"  id="input-file-now" class="dropify">
                                <input type="hidden" id="avatar" name="avatar">
                            </div>

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
            $('#option_s20').select2({
                placeholder: "انتخاب کنید",
                dir: "rtl"
            });
        });
        function encodeImageFileAsURL(element) {
            var file = element.files[element.files.length - 1];
            var reader = new FileReader();
            reader.onloadend = function() {
                $('#avatar').val(reader.result);
            };
            reader.readAsDataURL(file);
        }
        function getAccesses(element) {
            var this_ = element;
            var section_id = element.value;
            $.post('/accesses/ajax', {
                section_id: section_id,
            }, function (Res) {
                console.log(Res);
                $('#option_s20').html('').trigger('change');
                $('#option_s20').append(Res);
            });
        }
    </script>
@endsection