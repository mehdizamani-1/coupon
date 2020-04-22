<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('includes.user.styles_user')
    @yield('styles')
    <title>@yield('title')</title>


</head>

<body>

<div class="wrapper">


    @include('includes.user.header_user')
    @include('includes.info-box')

    @yield('content')


</div>


@include('includes.user.scripts_user')

<script>
    new WOW().init();

    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 6,
        spaceBetween: 30,
        // init: false,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        keyboard: {
            enabled: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        grabCursor: true,
        breakpoints: {
            1600: {
                slidesPerView: 5,
                spaceBetween: 30,
            },
            1300: {
                slidesPerView: 4,
                spaceBetween: 20,
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            650: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            375: {
                slidesPerView: 1,
                spaceBetween: 30,
            }
        }
    });

</script>


@yield('script')
</body>

</html>
