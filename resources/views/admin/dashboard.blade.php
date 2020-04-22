
@extends('layouts.operator_master')

@section('title')
داشبورد
@endsection
@section('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <!-------------------- Main Content ------------------>
    <div class="content-wrapper">
        <div class="content-title">
            <h1 class="h3 font-weight-bold"> میز کار</h1>
            <p class="mb-0">گزارشی از سایت</p>
        </div>
        @include('includes.info-box')
        <div class="row">
            <div class="col-lg-6 col-sm-6">
                <div class="card card-shadow">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="card-info py-3">
                            <h2 class="h3 font-weight-bold"> 0</h2>
                            <p class="mb-0">تعداد معاینه شده </p>
                        </div>
                        <div class="icon-info" style="color: #3bffed;"><i
                                    class="fa fa-stethoscope"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6">
                <div class="card card-shadow">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="card-info py-3">
                            <h2 class="h3 font-weight-bold"> 0</h2>
                            <p class="mb-0">تعداد لغویات </p>
                        </div>
                        <div class="icon-info" style="color: #e595ff;"><i class="fa fa-opencart"></i>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12 mb-4">
                <div class="card card-shadow h-100">
                    <div class="card-header border-0">
                        <h2 class="h6 py-3 mb-0 font-weight-bold card-title">اطلاعات شما</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.change.member.info') }}" class="forms-sample" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-sm-4">
                                    <label for="exampleInputUsername1">نام و نام خانوادگی</label>
                                    <input type="text" class="form-control" name="nickname" value="{{ $operator['nickname'] }}" id="exampleInputUsername1" placeholder="نام">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="exampleInputUsername1">کد ملی</label>
                                    <input type="text" class="form-control" name="national_id" id="exampleInputUsername1" value="{{ $operator['national_id'] }}" placeholder="کد">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="exampleInputUsername1">شماره همراه</label>
                                    <input type="tel" class="form-control" id="exampleInputUsername1" disabled="disabled" value="{{ $operator['mobile'] }}" placeholder="**********09">
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="exampleInputPassword1">عکس</label>
                                    <div class="custom-file">
                                        <input type="file" name="avatar" class="custom-file-input"
                                               id="customFileLangHTML">
                                        <label class="custom-file-label" for="customFileLangHTML"
                                               data-browse="آپلود فایل">انتخاب</label>
                                    </div>

                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="exampleInputPassword1">رمز عبور</label>
                                    <input type="password" class="form-control"
                                           id="exampleInputPassword1" name="password" placeholder="رمز ">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="exampleInputPassword1">رمز عبور جدید</label>
                                    <input type="password" class="form-control" name="new_pass"
                                           id="exampleInputPassword1" placeholder="رمز ">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="exampleInputPassword1">تکرار رمز عبور جدید</label>
                                    <input type="password" class="form-control" name="new_confirm_pass"
                                           id="exampleInputPassword1" placeholder="رمز ">
                                </div>

                            </div>
                            <button type="submit" class="btn btn-secondary px-5 py-2">ذخیره</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!---------------- remove-post-modal --------------->

@endsection
@section('script')

@endsection