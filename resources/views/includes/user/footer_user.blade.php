<footer class="main-footer">
    <div class="black-bg">
        <div class="container">
            <div class="row px-3">
                <div class="col-md-4 col-12 footer-logo px-4 d-flex align-items-center justify-content-center">
                    <img src="{{ $url }}{{ $white_logo->src }}" alt="{{ $white_logo->alt }}" class="footer-logo">

                </div>
                <div class="col-lg-4 col-md-8 col-12 p-4">
                    <h4 class="footer-title">درباره ما</h4>
                    <p>
                        {{ $store_info->about_us }}
                    </p>

                </div>
                <div class="col-lg-4 col-12 p-4">
                    <h4 class="footer-title">تماس با ما</h4>
                    <ul class="list-unstyled footer-contact">
                        <li>
                            <label for="">نشانی :</label>{{ $store_info->address }}
                        </li>
                        <li>
                            <label for="">تلفن :</label> {{ $store_info->phone_1 }}
                        </li>
                        <li>
                            <Label>ایمیل :</Label> {{ $store_info->email }}
                        </li>
                        <li>
                            <label for="">واحد پشتیبانی :</label> {{ $store_info->supplier_phone }}
                        </li>
                    </ul>

                </div>
                <div class="col-12 d-flex justify-content-center align-items-center symbol-section">
                    @foreach( $enamads as $enamad)
                        <figure class="d-flex justify-content-center align-items-center">
                            @if( $enamad->sequence == 1 )
                                <img src="{{ $enamad->src }}" alt="" onclick="window.open('{{ $enamad->url }}', 'Popup','toolbar=no, location=no, statusbar=no, menubar=no, scrollbars=1, resizable=0, width=580, height=600, top=30')" style="cursor:pointer" id="{{ $enamad->title }}">

                            @else
                                <img src="{{ $url }}/{{ $enamad->src }}" alt="" onclick="window.open('{{ $enamad->url }}', 'Popup','toolbar=no, location=no, statusbar=no, menubar=no, scrollbars=1, resizable=0, width=580, height=600, top=30')" style="cursor:pointer" id="{{ $enamad->title }}">

                            @endif
                        </figure>
                    @endforeach

                </div>
                <div class="col-12 mt-4">
                    <nav class="footer-nav">
                        <ul class="list-unstyled d-flex w-100 justify-content-center mb-0 flex-wrap">
                            <li><a class="text-nowrap" href="#">نمایندگی ها</a></li>
                            <li><a class="text-nowrap" href="#">درباره ما</a></li>
                            <li><a class="text-nowrap" href="#">تماس با ما</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-12 py-3 d-flex flex-wrap ">
                    <ul class="social-media list-unstyled d-flex justify-content-center justify-content-md-start">
                        @if( $store_info->telegram != '' )
                            <li><a href="{{ $store_info->telegram }}"><i class="fa fa-telegram"></i></a></li>
                        @endif
                        @if( $store_info->instagram != '' )
                            <li><a href="{{ $store_info->instagram }}"><i class="fa fa-instagram"></i></a></li>
                        @endif
                        @if( $store_info->twitter != '' )
                            <li><a href="{{ $store_info->twitter }}"><i class="fa fa-twitter"></i></a></li>
                        @endif
                        @if( $store_info->google_plus != '' )
                            <li><a href="{{ $store_info->google_plus }}"><i class="fa fa-google-plus"></i></a></li>

                        @endif
                        @if( $store_info->linkedin != '' )
                            <li><a href="{{ $store_info->linkedin }}"><i class="fa fa-linkedin"></i></a></li>
                        @endif
                        @if( $store_info->facebook != '' )
                            <li><a href="{{ $store_info->facebook }}"><i class="fa fa-facebook-f"></i></a></li>
                        @endif

                        @if( $store_info->aparat != '' )
                            <li><a href="{{ $store_info->aparat }}"><i class="icon-aparat aparat"></i></a></li>
                        @endif
                    </ul>

                    <div class="copyright mr-auto">
                        <div>{{ $store_info->rights_comment_en }}</div>
                        <div>{{ $store_info->rights_comment_fa }}</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>