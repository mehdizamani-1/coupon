<header class="main-header">
    <div class="top-bar d-flex justify-content-lg-between align-items-center">

        <div class="menu-btn">
            <span class="menu-item"></span>
            <span class="menu-item"></span>
            <span class="menu-item"></span>
        </div>
        <form enctype="multipart/form-data" action="{{ route('admin.panel.upload.image.post') }}" method="post">
            <input type="file" name="image">
            <input type="hidden" name="type" value="1">
            <button type="submit" class="btn main-btn ">آپلود لوگو</button>
        </form>
        <a href="{{ $logo->url }}" class="logo"><img src="{{ $url }}{{ $logo->src }}" alt="{{ $logo->alt }}"></a>

        <nav class="main-nav">

            <ul>
                <li><a href="" class="spy-btn">صفحه اصلی</a></li>
                <li><a href="" class="spy-btn">فروشگاه</a></li>
                <li><a href="" class="spy-btn">وبلاگ</a></li>
                <li><a href="" class="spy-btn">نمایندگی ها</a></li>




            </ul>
        </nav>
        <div class="mr-auto header-login">
            <a href="{{ route('admin.panel.dashboard') }}" class="btn main-btn btn-success">
                بازگشت
            </a>
        </div>
        <div class="mr-auto header-login">
            <a href="#" class="btn main-btn spy-btn dark-brown-bg">
                ثبت نام
            </a>
            <a href="#" class="btn main-btn spy-btn mr-1">
                ورود
            </a>
        </div>


    </div>
    <div id="main-slider" class="carousel carousel-fade slide main-slider" data-ride="carousel">

        <!-- Indicators -->
        <ul class="carousel-indicators">
            @if(isset($main_slides))
                <?php $i = 0 ?>
                @foreach ($main_slides as $main_slide)
                    <li data-target="#main-slider" @if( $i == 0 ) class="active" @endif data-slide-to="{{ $i++ }}"></li>
                @endforeach
            @endif
        </ul>

        <!-- The slideshow -->
        <div class="carousel-inner">
            @if(isset($main_slides))
                <?php $i = 1 ?>
                @foreach ($main_slides as $main_slide)

                <a href="#" class="carousel-item @if( $i == 1 ) active @endif " style="background-image: url({{ $url.'/'.$main_slide['src'] }});">
                    <div class="slider-cap d-flex align-content-center flex-wrap w-100 h-100">
                        <h1 class="slider-title w-100">{{ $main_slide['title'] }}</h1>
                        <h1 class="slider-second-title w-100">{{ $main_slide['text'] }}</h1>
                        <div class="slider-caption w-100">
                            {{ $main_slide['text2'] }}
                        </div>


                    </div>
                </a>
                    <?php $i++; ?>
               @endforeach
           @endif

        </div>

        <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#main-slider" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#main-slider" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>

    </div>

    <form class="form-group" enctype="multipart/form-data" action="{{ route('admin.panel.footer.setting.post') }}" method="post">
        <div class="form-group">
            <label>متن توضیحی صفحه(150 کاراکتر)</label>
            <input type="text" name="content" class="form-control col-md-4" value="{{ $store_info->content }}" placeholder="متن توضیحی صفحه(سئو)">
        </div>
        <div class="form-group">
            <label>کلمات کلیدی</label>
            <input type="text" name="keywords" class="form-control col-md-4" value="{{ $store_info->keywords }}" placeholder="کلمات کلیدی صفحه(با کاما جدا شود)">
        </div>
        <input type="hidden" name="type" value="5">
        <div class="form-group">
            <label>هرآنچه در هدر قرار گیرد</label>
            <textarea name="meta" class="form-control col-md-4"  placeholder="هدر">{{ $store_info->meta }}</textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn main-btn ">ثبت</button>
        </div>
    </form>
    <form class="form-group" enctype="multipart/form-data" action="{{ route('admin.panel.upload.image.post') }}" method="post">
        <div class="form-group">
            <label>چند تصویری: </label>
            <input type="file" name="image[]" placeholder="تصویر" multiple>
            <input type="text" name="alt" placeholder="متن تصویر">
        </div>
        <div class="form-group">
            <input type="text" name="title" class="form-control col-md-4" value="{{ $main_slide->title }}" placeholder="عنوان اصلی">
        </div>
        <div class="form-group">
            <input type="text" name="text" class="form-control col-md-4" value="{{ $main_slide->text }}" placeholder="عنوان دو">
        </div>
        <input type="hidden" name="type" value="2">
        <div class="form-group">
            <textarea class="form-control col-md-4" name="text2" placeholder="متن">{{ $main_slide->text2 }}</textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn main-btn ">آپلود تصویر و متن</button>
        </div>
    </form>


</header>