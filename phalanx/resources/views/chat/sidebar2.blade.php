<?php
//$chat_roomが渡されているとき参加者の情報を取得
if(isset($chat_room)) {
    $chatRoomUsers = $chat_room->chat_room__user->whereNull("deleted_at");
    if(isset($chatRoomUsers)) {
        $officers = [];
        $users = [];
        $trials = [];
        foreach($chatRoomUsers as $chatRoomUser) {

            //職員のデータをoffice_idをキーにして$officersに入れる
            if($chatRoomUser->user->user_type_id == 1) {

                //$officersにすでにoffice_idと同じキーの配列があればその配列の後ろに入れ、なければ作る
                if(isset($officers[$chatRoomUser->user->office_id])) {
                    arary_push($officers[$chatRoomUser->user->office_id], $chatRoomUser->user);
                } else {
                    $officers[$chatRoomUser->user->office_id] = [$chatRoomUser->user];
                }
            } 
            
            //利用者も同様に処理する
            else if($chatRoomUser->user->user_type_id == 2) {
                if(isset($users[$chatRoomUser->user->office_id])) {
                    arary_push($users[$chatRoomUser->user->office_id], $chatRoomUser->user);
                } else {
                    $users[$chatRoomUser->user->office_id] = [$chatRoomUser->user];
                }
            }

            //体験者を$trialsに入れる
            else {
                $trials[] = $chatRoomUser->user;
            }
        }
    }
}
?>


@extends('layouts.app')

@section('css')
<link href="{{ asset('css/navigation.css') }}" rel="stylesheet">
@yield("c_css")
@endsection

@section("content")

{{-- 左ナビゲーション --}}
<div id="nav-left-container" class="d-block d-md-none" style='visibility: hidden'>
    <div id="nav-button-left" class="nav-button openbtn d-flex align-items-center justify-content-end" data-is-open="false"><i class="fas fa-chevron-right"></i></div>
    <nav id="nav-left" class="edge-nav">
        @if (Auth::user()->user_type_id == 1)
            <div class="p-3">
                <a href="{{ route('chat.index') }}" class="btn btn-primary btn-lg btn-block" role="button">通所者一覧</a>
            </div>
        @endif
        <div class="">
            @if (isset($group))
                <div class="col-12 pt-3">
                    <h5>リテラル</h5>
                    <ul class="col-12 pt-1">
                        <li><a href="{{ route("chat.show", $group->id) }}">全職員</a></li>
                    </ul>
                </div>
            @endif
            @foreach ($offices as $office)
                @if ($office->id == Auth::user()->office_id)
                    <div class="col-12 pt-3">
                        <h5>{{ $office->office_name }}</h5>
                        <ul class="col-12 pt-1">
                            @foreach ($joinRooms as $joinRoom)
                                @if ($joinRoom->office_id == $office->id)
                                    <li>
                                        @if ($joinRoom->distinction_number == 4)
                                            <a href="{{ route('chat.show', $joinRoom->id) }}">{{ $joinRoom->room_title }}</a>
                                        @else
                                            <a href="{{ route('chat.show', $joinRoom->id) }}">{{ $office->office_name }}職員</a>
                                        @endif
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endforeach
            <div class="col-12 px-0">
                <div>
                    <button type="button" class="btn btn-outline-dark btn-block sub-offices" data-toggle="collapse" data-target="#subOffices" aria-expanded="false" aria-controls="subOffices">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="collapse" id="subOffices">
                    @foreach ($offices as $office)
                        @if ($office->id != Auth::user()->office_id)
                            <div class="col-12 pt-3">
                                <h5>{{ $office->office_name }}</h5>
                                <ul class="col-12 pt-1">
                                    @foreach ($joinRooms as $joinRoom)
                                        @if ($joinRoom->office_id == $office->id)
                                            <li>
                                                @if ($joinRoom->distinction_number == 4)
                                                    <a href="{{ route('chat.show', $joinRoom->id) }}">{{ $joinRoom->room_title }}</a>
                                                @else
                                                    <a href="{{ route('chat.show', $joinRoom->id) }}">{{ $office->office_name }}職員</a>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </nav>
</div>

{{-- 右ナビゲーション --}}
<div id="nav-right-container" class="d-block d-md-none" style='visibility: hidden'>
    <div id="nav-button-right" class="nav-button openbtn d-flex align-items-center justify-content-start" data-is-open="false"><i class="fas fa-chevron-left"></i></div>
    <nav id="nav-right" class="edge-nav">
        <div class="m-2">
            @if (isset($chat_room))
                <div class="row">
                    <h5 class="col-12 pt-3 font-weight-bold">参加者 ({{ $chatRoomUsers->count() }})</h5>
                </div>
                <div class="row">
                    @foreach ($offices as $office)
                        @if (isset($officers[$office->id]))
                            <div>
                                <a data-toggle="collapse" href="#staff-{{ $office->id }}" class="no-close">
                                    <h5 class="col-12 pt-3 text-danger font-weight-bold">{{ $office->office_name }}職員 ({{ count($officers[$office->id]) }})</h5>
                                </a>
                                <ul id="staff-{{ $office->id }}" class="col-12 pt-1 collapse show">
                                    @foreach ($officers[$office->id] as $officer)
                                        <li class="{{ $officer->id==Auth::user()->id ? 'text-primary' : 'text-danger' }}">{{ $officer->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="row">
                    @foreach ($offices as $office)
                        @if (isset($users[$office->id]))
                            <div>
                                <a data-toggle="collapse" href="#user-{{ $office->id }}" class="no-close">
                                    <h5 class="col-12 pt-3 text-success font-weight-bold">{{ $office->office_name }}通所者 ({{ count($users[$office->id]) }})</h5>
                                </a>
                                <ul id="user-{{ $office->id }}" class="col-12 pt-1  collapse show">
                                    @foreach ($users[$office->id] as $user)
                                        <li class="{{ $officer->id==Auth::user()->id ? 'text-primary' : 'text-success' }}">{{ $user->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="row">
                    @if (isset($trials[0]))
                        <a data-toggle="collapse" href="#trial-{{ $office->id }}" class="no-close">
                            <h5 class="col-12 pt-3 text-success font-weight-bold">体験者 ({{ count($trials) }})</h5>
                        </a>
                        <ul id="trial-{{ $office->id }}" class="col-12 pt-1  collapse show">
                            @foreach ($trials as $trial)
                                <li class="{{ $officer->id==Auth::user()->id ? 'text-primary' : 'text-success' }}">{{ $trial->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif
        </div>
    </nav>
</div>

{{-- ナビゲーション表示時の背景オーバーレイ --}}
<div id="cover" style="position: fixed; top: 0; left: 0; width: 100%; height:100%; z-index: 990; background-color: #00000055" hidden>
</div>



<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 d-none d-md-block border border-dark px-0">
            <div class="scroll-contents container-fluid">
                @if (Auth::user()->user_type_id == 1)
                    <div class="row p-3">
                        <a href="{{ route('chat.index') }}" class="btn btn-primary btn-lg btn-block" role="button">通所者一覧</a>
                    </div>
                @endif
                <div class="row">
                    @if (isset($group))
                        <div class="col-12 pt-3">
                            <h5>リテラル</h5>
                            <ul class="col-12 pt-1">
                                <li><a href="{{ route("chat.show", $group->id) }}">全職員</a></li>
                            </ul>
                        </div>
                    @endif
                    @if (isset($otherRooms))
                        <div class="col-12 pt-3">
                            <h5>その他</h5>
                            <ul class="col-12 pt-1">
                                @foreach ($otherRooms as $otherRoom)
                                    <li><a href="{{ route('chat.show', $otherRoom->id) }}">{{ $otherRoom->room_title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @foreach ($offices as $office)
                        @if ($office->id == Auth::user()->office_id)
                            <div class="col-12 pt-3">
                                <h5>{{ $office->office_name }}</h5>
                                <ul class="col-12 pt-1">
                                    @foreach ($joinRooms as $joinRoom)
                                        @if ($joinRoom->office_id == $office->id)
                                            <li>
                                                @if ($joinRoom->distinction_number == 4)
                                                    <a href="{{ route('chat.show', $joinRoom->id) }}">{{ $joinRoom->room_title }}</a>
                                                @else
                                                    <a href="{{ route('chat.show', $joinRoom->id) }}">{{ $office->office_name }}職員</a>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endforeach
                    <div class="col-12 px-0">
                        <div>
                            <button type="button" class="btn btn-outline-dark btn-block sub-offices" data-toggle="collapse" data-target="#subOffices" aria-expanded="false" aria-controls="subOffices">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <div class="collapse" id="subOffices">
                            @foreach ($offices as $office)
                                @if ($office->id != Auth::user()->office_id)
                                    <div class="col-12 pt-3">
                                        <h5>{{ $office->office_name }}</h5>
                                        <ul class="col-12 pt-1">
                                            @foreach ($joinRooms as $joinRoom)
                                                @if ($joinRoom->office_id == $office->id)
                                                    <li>
                                                        @if ($joinRoom->distinction_number == 4)
                                                            <a href="{{ route('chat.show', $joinRoom->id) }}">{{ $joinRoom->room_title }}</a>
                                                        @else
                                                            <a href="{{ route('chat.show', $joinRoom->id) }}">{{ $office->office_name }}職員</a>
                                                        @endif
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 bg-white border-top p-0">
            <div class="scroll-contents" id="center-scroll">
                @yield('center')
            </div>
            @yield("c_modal")
        </div>
        <div class="col-md-2 d-none d-md-block border border-dark pr-0">
            <div class="scroll-contents">
                @if (isset($chat_room))
                    <div class="row">
                        <h5 class="col-12 pt-3 font-weight-bold">参加者 ({{ $chatRoomUsers->count() }})</h5>
                    </div>
                    <div class="row">
                        @foreach ($offices as $office)
                            @if (isset($officers[$office->id]))
                                <div>
                                    <a data-toggle="collapse" href="#staff-{{ $office->id }}">
                                        <h5 class="col-12 pt-3 text-danger font-weight-bold">{{ $office->office_name }}職員 ({{ count($officers[$office->id]) }})</h5>
                                    </a>
                                    <ul id="staff-{{ $office->id }}" class="col-12 pt-1 collapse show">
                                        @foreach ($officers[$office->id] as $officer)
                                            <li class="{{ $officer->id==Auth::user()->id ? 'text-primary' : 'text-danger' }}">{{ $officer->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="row">
                        @foreach ($offices as $office)
                            @if (isset($users[$office->id]))
                                <div>
                                    <a data-toggle="collapse" href="#user-{{ $office->id }}">
                                        <h5 class="col-12 pt-3 text-success font-weight-bold">{{ $office->office_name }}通所者 ({{ count($users[$office->id]) }})</h5>
                                    </a>
                                    <ul id="user-{{ $office->id }}" class="col-12 pt-1  collapse show">
                                        @foreach ($users[$office->id] as $user)
                                            <li class="{{ $officer->id==Auth::user()->id ? 'text-primary' : 'text-success' }}">{{ $user->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="row">
                        @if (isset($trials[0]))
                            <a data-toggle="collapse" href="#trial-{{ $office->id }}">
                                <h5 class="col-12 pt-3 text-success font-weight-bold">体験者 ({{ count($trials) }})</h5>
                            </a>
                            <ul id="trial-{{ $office->id }}" class="col-12 pt-1  collapse show">
                                @foreach ($trials as $trial)
                                    <li class="{{ $officer->id==Auth::user()->id ? 'text-primary' : 'text-success' }}">{{ $trial->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
{{-- クラス読み込み --}}
<script src="{{ asset('js/cover.js') }}"></script>
<script src="{{ asset('js/touchInfo.js') }}"></script>
<script src="{{ asset('js/edgeNavigation.js') }}"></script>

<script>

    var fRightNav = {{ isset($chat_room) ? 'true' : 'false' }};

    $(function() {

        //------------ ナビゲーションバーの動作 ------------------------------------------

        // インスタンス作成
        var touch = new touchInfo(5);
        var navManager = new navigationManager();
        touch.addStartCallBack(navManager.touchStart, navManager);
        touch.addMoveCallBack(navManager.touchMove, navManager);
        touch.addEndCallBack(navManager.touchEnd, navManager);
        navManager.add( 'left', 4, 32, 16 );
        if(fRightNav) navManager.add( 'right', 2, 32, 16 );

        // ※アニメーション確認用
        // const observer = new MutationObserver((mutationsList, observer) => {
        //     mutationsList.forEach(({target, oldValue}) => {
        //         console.log(target.style.transition);
        //         console.log('old: '+oldValue);
        //     });
        // });
        // observer.observe(document.querySelector('#cover'), { attributes: true, childList: true, subtree: true });


        //------------ その他の動作 ------------------------------------------

        //ナビゲーションバーの高さを取得
        let navHeight = $("nav").innerHeight();

        //.scroll-contentsの高さを調整
        $(".scroll-contents").css("height", `calc(100vh - 2px - ${navHeight}px)`);
        $("main").css("height", `calc(100vh - 2px - ${navHeight}px)`);


        //#sub-officesが押された時の動作
        $(".sub-offices").click(function(){
            let fas = $(this).find(".fas");
            if( fas.hasClass("fa-chevron-down") ) {
                fas.removeClass("fa-chevron-down");
                fas.addClass("fa-chevron-up");
            } else {
                fas.removeClass("fa-chevron-up");
                fas.addClass("fa-chevron-down");
            }
        });

    });

</script>

@yield("c_script")
@endsection