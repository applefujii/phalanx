<?php
//$chat_roomが渡されているとき参加者の情報を取得
if(isset($chat_room)) {
    $chatRoomUsers = $chat_room->chat_room__user;
    if(isset($chatRoomUsers)) {
        $officers = [];
        $users = [];
        $trials = [];
        foreach($chatRoomUsers as $chatRoomUser) {

            //職員のデータをoffice_idをキーにして$officersに入れる
            if($chatRoomUser->user->user_type_id == 1) {

                //$officersにすでにoffice_idと同じキーの配列があればその配列の後ろに入れ、なければ作る
                if(isset($officers[$chatRoomUser->user->office_id])) {
                    array_push($officers[$chatRoomUser->user->office_id], $chatRoomUser->user);
                } else {
                    $officers[$chatRoomUser->user->office_id] = [$chatRoomUser->user];
                }
            } 
            
            //利用者も同様に処理する
            else if($chatRoomUser->user->user_type_id == 2) {
                if(isset($users[$chatRoomUser->user->office_id])) {
                    array_push($users[$chatRoomUser->user->office_id], $chatRoomUser->user);
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
<link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
@yield("c_css")
@endsection

@section("content")
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
                                <li><a href="{{ route("chat.show", $group->id) }}"
                                    @if($group->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->first() !== null)
                                        @if($group->chat_room__user()->where("user_id", Auth::id())->first()->newest_read_chat_text_id < $group->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->orderBy("id", "desc")->first()->id)
                                            class="text-danger"
                                        @endif
                                    @endif
                                >
                                    全職員
                                </a></li>
                            </ul>
                        </div>
                    @endif
                    @if (isset($otherRooms))
                        <div class="col-12 pt-3">
                            <h5>その他</h5>
                            <ul class="col-12 pt-1">
                                @foreach ($otherRooms as $otherRoom)
                                    <li><a href="{{ route('chat.show', $otherRoom->id) }}"
                                        @if($otherRoom->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->first() !== null)
                                            @if($otherRoom->chat_room__user()->where("user_id", Auth::id())->first()->newest_read_chat_text_id != $otherRoom->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->orderBy("id", "desc")->first()->id)
                                                class="text-danger"
                                            @endif
                                        @endif
                                    >
                                        {{ $otherRoom->room_title }}
                                    </a></li>
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
                                                    <a href="{{ route('chat.show', $joinRoom->id) }}"
                                                        @if($joinRoom->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->first() !== null)
                                                            @if($joinRoom->chat_room__user()->where("user_id", Auth::id())->first()->newest_read_chat_text_id != $joinRoom->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->orderBy("id", "desc")->first()->id)
                                                                class="text-danger"
                                                            @endif
                                                        @endif
                                                    >
                                                        {{ $joinRoom->room_title }}
                                                    </a>
                                                @else
                                                    <a href="{{ route('chat.show', $joinRoom->id) }}"
                                                        @if($joinRoom->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->first() !== null)
                                                            @if($joinRoom->chat_room__user()->where("user_id", Auth::id())->first()->newest_read_chat_text_id != $joinRoom->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->orderBy("id", "desc")->first()->id)
                                                                class="text-danger"
                                                            @endif
                                                        @endif
                                                    >
                                                        {{ $office->office_name }}職員
                                                    </a>
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
                                                            <a href="{{ route('chat.show', $joinRoom->id) }}"
                                                                @if($joinRoom->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->first() !== null)
                                                                    @if($joinRoom->chat_room__user()->where("user_id", Auth::id())->first()->newest_read_chat_text_id != $joinRoom->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->orderBy("id", "desc")->first()->id)
                                                                        class="text-danger"
                                                                    @endif
                                                                @endif
                                                            >
                                                                {{ $joinRoom->room_title }}
                                                            </a>
                                                        @else
                                                            <a href="{{ route('chat.show', $joinRoom->id) }}"
                                                                @if($joinRoom->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->first() !== null)
                                                                    @if($joinRoom->chat_room__user()->where("user_id", Auth::id())->first()->newest_read_chat_text_id != $joinRoom->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->orderBy("id", "desc")->first()->id)
                                                                        class="text-danger"
                                                                    @endif
                                                                @endif
                                                            >
                                                                {{ $office->office_name }}職員
                                                            </a>
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
            <button type="button" class="btn btn-dark rounded-circle position-fixed mt-5 d-block d-md-none sidebar-open" id="left-open" data-toggle="modal" data-target="#left-modal">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="modal fade" id="left-modal" tabindex="-1">
                <div class="modal-dialog d-md-none">
                    <div class="modal-content h-100">
                        <div class="modal-body">
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
                                            <li><a href="{{ route("chat.show", $group->id) }}"
                                                @if($group->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->first() !== null)
                                                    @if($group->chat_room__user()->where("user_id", Auth::id())->first()->newest_read_chat_text_id != $group->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->orderBy("id", "desc")->first()->id)
                                                        class="text-danger"
                                                    @endif
                                                @endif
                                            >
                                                全職員
                                            </a></li>
                                        </ul>
                                    </div>
                                @endif
                                @if (isset($otherRooms))
                                    <div class="col-12 pt-3">
                                        <h5>その他</h5>
                                        <ul class="col-12 pt-1">
                                            @foreach ($otherRooms as $otherRoom)
                                                <li><a href="{{ route('chat.show', $otherRoom->id) }}"
                                                    @if($otherRoom->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->first() !== null)
                                                        @if($otherRoom->chat_room__user()->where("user_id", Auth::id())->first()->newest_read_chat_text_id != $otherRoom->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->orderBy("id", "desc")->first()->id)
                                                            class="text-danger"
                                                        @endif
                                                    @endif
                                                >
                                                    {{ $otherRoom->room_title }}
                                                </a></li>
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
                                                                <a href="{{ route('chat.show', $joinRoom->id) }}"
                                                                    @if($joinRoom->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->first() !== null)
                                                                        @if($joinRoom->chat_room__user()->where("user_id", Auth::id())->first()->newest_read_chat_text_id != $joinRoom->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->orderBy("id", "desc")->first()->id)
                                                                            class="text-danger"
                                                                        @endif
                                                                    @endif
                                                                >
                                                                    {{ $joinRoom->room_title }}
                                                                </a>
                                                            @else
                                                                <a href="{{ route('chat.show', $joinRoom->id) }}"
                                                                    @if($joinRoom->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->first() !== null)
                                                                        @if($joinRoom->chat_room__user()->where("user_id", Auth::id())->first()->newest_read_chat_text_id != $joinRoom->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->orderBy("id", "desc")->first()->id)
                                                                            class="text-danger"
                                                                        @endif
                                                                    @endif
                                                                >
                                                                    {{ $office->office_name }}職員
                                                                </a>
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
                                                                        <a href="{{ route('chat.show', $joinRoom->id) }}"
                                                                            @if($joinRoom->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->first() !== null)
                                                                                @if($joinRoom->chat_room__user()->where("user_id", Auth::id())->first()->newest_read_chat_text_id != $joinRoom->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->orderBy("id", "desc")->first()->id)
                                                                                    class="text-danger"
                                                                                @endif
                                                                            @endif
                                                                        >
                                                                            {{ $joinRoom->room_title }}
                                                                        </a>
                                                                    @else
                                                                        <a href="{{ route('chat.show', $joinRoom->id) }}"
                                                                            @if($joinRoom->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->first() !== null)
                                                                                @if($joinRoom->chat_room__user()->where("user_id", Auth::id())->first()->newest_read_chat_text_id != $joinRoom->chat_texts()->whereNull("deleted_at")->where("create_user_id", "<>", Auth::id())->orderBy("id", "desc")->first()->id)
                                                                                    class="text-danger"
                                                                                @endif
                                                                            @endif
                                                                        >
                                                                            {{ $office->office_name }}職員
                                                                        </a>
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
                </div>
            </div>
            @if (isset($chat_room))
                <button type="button" class="btn btn-dark rounded-circle position-fixed mt-5 d-block d-md-none sidebar-open" id="right-open" data-toggle="modal" data-target="#right-modal">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="modal fade" id="right-modal" tabindex="-1">
                    <div class="modal-dialog d-md-none">
                        <div class="modal-content h-100">
                            <div class="modal-body">
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
            @endif

            @yield('center')

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
<script>
    $(function() {

        //ナビゲーションバーの高さを取得
        let navHeight = $("nav").innerHeight();

        //.scroll-contentsの高さを調整
        $(".scroll-contents").css("height", `calc(100vh - 2px - ${navHeight}px)`);
        $("main").css("height", `calc(100vh - 2px - ${navHeight}px)`);
        
        $(".navbar-toggler").click(function() {
            setTimeout(function() {
                navHeight = $("nav").innerHeight();
                $(".scroll-contents").css("height", `calc(100vh - 2px - ${navHeight}px)`);
                $("main").css("height", `calc(100vh - 2px - ${navHeight}px)`);
            }, 500);
        });

        $("#navbarDropdown").click(function() {
            setTimeout(function() {
                navHeight = $("nav").innerHeight();
                $(".scroll-contents").css("height", `calc(100vh - 2px - ${navHeight}px)`);
                $("main").css("height", `calc(100vh - 2px - ${navHeight}px)`);
            }, 100);
        })

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