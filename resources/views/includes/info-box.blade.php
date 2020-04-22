
@section('styles')

@append

@if(\Session::has('Fail'))
    <div class="alert alert-danger" role="alert">
    {{ \Session::get('Fail') }}
    <?php
    \Session::forget('Fail');
    ?>
    </div>
@endif
@if(\Session::has('fail'))
    <div class="alert alert-danger" role="alert">
    {{ \Session::get('fail') }}
    </div>
    <?php
    \Session::forget('fail');
    ?>

@endif

@if(\Session::has('fail2'))
    <div class="alert alert-danger" role="alert">
    {{ \Session::get('fail2') }}
    </div>
    <?php
    \Session::forget('fail2');
    ?>
@endif

@if(\Session::has('warn'))
    <div class="alert alert-warning" role="alert">
    {{ \Session::get('warn') }}
    </div>
    <?php
    \Session::forget('warn');
    ?>

@endif



@if(\Session::has('Success'))
    <div class="alert alert-success" role="alert">
        {{ \Session::get('Success') }}
    </div>
    <?php
    \Session::forget('Success');
    ?>

@endif

@if(\Session::has('success'))
    <div class="alert alert-success" role="alert">
    {{ \Session::get('success') }}
    </div>
    <?php
    \Session::forget('success');
    ?>
@endif

@if(\Session::has('success2'))
    <div class="alert alert-success" role="alert">
    {{ \Session::get('success2') }}
    </div>
@endif


@if(Session::has('errors') )
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach(Session::get('errors')->all() as $error)
                <li>{{ $error }}</li>

            @endforeach
            @php
                \Session::forget('errors');
            @endphp
        </ul>
    </div>
@endif

