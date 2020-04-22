<?php
use App\SectionMessage;
$url = \Config::get('app.url_request');
$unseen_messages = $messages = SectionMessage::select('section_messages.*')
    ->whereRaw(\Illuminate\Support\Facades\DB::raw("FIND_IN_SET( '3', section_messages.reference_types)") )
    ->Raw(\Illuminate\Support\Facades\DB::raw(' AND section_messages.id NOT IN (SELECT message_id from `section_messages_seen`) ') )
    ->get();
$unseen_count = count($unseen_messages);
?>

<header class="header fixed-top w-100 py-2">
    <div class="container-fluid">
        <div class="row justify-content-between align-items-center">
            <div class="col-auto ">
                <div class="d-flex flex-row align-items-center">
                    <div class="close-nav-right">
                        <i class="fa fa-align-right py-2 px-3"></i>
                    </div>
                    <div class="logo pr-sm-5"><img src="/uploads/img/main-logo.png" alt="" style="height: 35px;"></div>
                </div>
            </div>
            <div class="col-auto">
                <ul class="list-unstyled list-group-horizontal mb-0">
                    <li class="search list-inline-item">
                        <div class="search-icon p-2"> <i class="fa fa-search"></i></div>
                        <div class="search-form" style="display: none;">
                            <div class="form-group mb-0">
                                <input type="text" class="form-control w-100" id="exampleInputUsername1"
                                       placeholder="کلمه مورد جستجو">
                            </div>
                            <button> <i class="fa fa-search"></i></button>
                        </div>
                    </li>
                    <li class="notificate list-inline-item">
                        <a href="#" class="p-2 dropdown-toggle" id="messagesDropdown" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="true"> <i class="fa fa-bell-o"></i>
                            @if( $unseen_count > 0 )
                                <span class="badge-custom badge-color-2"><span class="badge-animate"></span><i class="fa fa-circle"></i></span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-left pb-0"
                             aria-labelledby="messagesDropdown">
                            <h6 class="dropdown-header font-weight-bold mb-0 text-dark">پیام ها</h6>
                            <div class="dropdown-divider mb-0"></div>
                            @foreach( $unseen_messages as $unseen_message )
                                <a class="dropdown-item mb-0 py-3 text-dark small alert alert-warning border-0" href="{{ route('admin.messages', ['message_id' => $unseen_message['id']]) }}">
                                    {!! $unseen_message['message'] !!}
                                </a>
                            @endforeach

                        </div>
                    </li>
                    <li class="user list-inline-item">
                        <a href="#" title="فعال کردن" class="py-2 pr-2 dropdown-toggle avatar"
                           id="messagesDropdown" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="true"><img src="{{ $url . '/'. $operator['avatar'] }}" alt="">
                        </a>
                        <div class="dropdown-menu dropdown-menu-left pb-0"
                             aria-labelledby="messagesDropdown">
                            <h6 class="dropdown-header avatar"><img src="{{ $url . '/'. $operator['avatar'] }}" alt=""
                                                                    class="float-right ml-3">
                                <div class="h6 font-weight-bold mb-0 text-dark ">{{ $operator['nickname'] }}</div>
                            </h6>
                            <div class="dropdown-divider mb-0"></div>

                            <a class="dropdown-item mb-0 py-2 pb-3  text-dark btn-sm" href="{{ route('admin.messages') }}">پیام ها <span
                                        class="badge badge-success float-left mt-1">{{ $unseen_count }}</span></a>

                            <a class="dropdown-item mb-0 py-3 text-dark border-top btn-sm" href="{{ route('admin.post.logout') }}">
                                خروج
                            </a>

                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>