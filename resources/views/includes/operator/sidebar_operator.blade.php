<!-------------------- Right Menu -------------------->


<div class="sidebar-right">
    <nav class="nav-sidebar">
        <ul class="nav-bar">
            <li><a href="{{ route('admin.panel.dashboard') }}" @if( Route::current()->getName() == 'admin.panel.dashboard'  ) class="active" @endif><i class="fa fa-home"></i>میزکار</a></li>
            <li><a href="{{ route('admin.time.works') }}" @if( Route::current()->getName() == 'admin.time.works'  ) class="active" @endif><i class="fa fa-address-card-o"></i>ثبت ساعات ویزیت</a></li>
            <li><a href="{{ route('panel.comments') }}" @if( Route::current()->getName() == 'panel.comments'  ) class="active" @endif><i class="fa fa-comment"></i>نظرات</a></li>

            <li class="sub-list">
                <a href="javascript:void(0)"><i class="fa fa-heartbeat"></i>بیماران</a>
                <ul class="sub-menu" style="display: none;">
                    <li><a href="{{ route('admin.visit.requests') }}" @if( Route::current()->getName() == 'admin.visit.requests' ) class="active" @endif>درخواست های بیماران</a></li>
                    <li><a href="{{ route('admin.visits') }}" @if( Route::current()->getName() == 'admin.visits' ) class="active" @endif>ویزیت های مورد قبول</a></li>
                    <li><a href="{{ route('admin.visits.prescription') }}" @if( Route::current()->getName() == 'admin.visits.prescription' ) class="active" @endif>پرونده های بیماران</a></li>
                    <li><a href="{{ route('admin.visit.create') }}" @if( Route::current()->getName() == 'admin.visit.create' ) class="active" @endif>ثبت ویزیت</a></li>

                </ul>
            </li>
            <li class="sub-list">
                <a href="#"><i class="fa fa-user"></i>کارمندان</a>
                <ul class="sub-menu" style="display: none;">

                    <li><a href="{{ route('panel.accounts.show') }}" class="@if( Route::current()->getName() == 'panel.accounts.show' ) active @endif">لیست کارمندان</a></li>
                    <li><a href="{{ route('panel.accounts.account.create') }}" class="@if( Route::current()->getName() == 'panel.accounts.account.create' ) active @endif">ثبت کارمند</a></li>
                </ul>
            </li>


        </ul>
    </nav>
</div>






