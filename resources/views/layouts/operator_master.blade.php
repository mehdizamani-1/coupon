<!doctype html>
<html lang="fa">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('includes.operator.styles')
    @yield('styles')
    <title>@yield('title')</title>


</head>

<body class="body">
@include('includes.operator.header')
<main class="main">
    <div class="container-fluid">
        @include('includes.operator.sidebar_operator')
        @yield('content')
    </div>
</main>
<footer>
</footer>
@include('includes.operator.scripts')

<script>

    $(document).ready(function() {
        $('.pagination').find('span').addClass('page-link');
        $('.pagination').find('li').addClass('page-item');
    });
</script>
@yield('script')

<script src="{{ URL::to('src/js/custom.js') }}"></script>
</body>


</html>


