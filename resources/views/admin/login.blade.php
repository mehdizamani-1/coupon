

<!doctype html>
<html lang="fa">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ورود</title>
    <link rel="stylesheet" type="text/css" href="{{ URL::to('src/css/bootstrap-cust.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('src/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('src/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('src/css/color.css') }}">
    <script src="{{ URL::to('src/js/jquery.min.js') }}"></script>
    <style>
        .bg-login {
            background-size: cover;
            background-repeat: no-repeat;
        }

        .login-info {
            min-height: 100vh;
            background: #fff;
        }
        .login-info .input-group-prepend .input-group-text {
            background: transparent;
            width: 50px;
            display: flex;
            justify-content: center;
            text-align: center;
            border: 1px solid #e9e8ef;
        }
    </style>
</head>



<body class="body">
    <div class="container-fluid px-3">
        <div class="row flex-grow login-info">
            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8 col-md-6 col-sm-8 text-center p-3">
                        @include('includes.info-box')
                        <div class="brand-logo">
                            <img src="/uploads/img/main-logo.png" alt="logo" width="150px">
                        </div>
                        <h4 class="h5 font-weight-bold mt-3">ورود به پنل مدیریت</h4>
                        <form action="{{ route('admin.post.login') }}" method="post" class="forms-sample text-right py-4">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-row align-items-center">
                                <div class="form-group col-12">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-user"></i></div>
                                        </div>
                                        <input type="number" name="mobile" class="form-control" id="exampleInputUsername1" placeholder="موبایل">
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-lock"></i></div>
                                        </div>
                                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="رمز عبور">
                                    </div>
                                </div>
{{--                                <div class="form-group col-6">--}}
{{--                                    <label for="">عبارت روبرو را وارد کنید</label>--}}
{{--                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="">--}}
{{--                                </div>--}}
{{--                                <div class="form-group col-6">--}}
{{--                                    <img src="/uploads/img/fig-1.jpg" alt="" class="img-fluid">--}}
{{--                                </div>--}}

                                <div class="form-group col-4 pt-3">
                                    <button type="submit" class="btn btn-success w-100">ارسال</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 bg-login d-flex flex-row" style="background-image: url('/uploads/img/login-bg-2.jpg')">

            </div>
        </div>
    </div>
</body>
<script src="{{ URL::to('src/js/jquery-3.3.1.slim.min.js') }}"></script>
<script src="{{ URL::to('src/js/popper.min.js') }}"></script>
<script src="{{ URL::to('src/js/jquery.min.js') }}"></script>
<script src="{{ URL::to('src/js/jquery-ui.min.js') }}"></script>
<script src="{{ URL::to('src/js/bootstrap.min.js') }}"></script>
<script>
    $(function () {
        $('.tooltip-cust').tooltip()
    })
</script>

</html>





