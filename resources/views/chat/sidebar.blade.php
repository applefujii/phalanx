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
                    array_push($officers[$chatRoomUser->user->office_id], $chatRoomUser->user->name);
                } else {
                    $officers[$chatRoomUser->user->office_id] = [$chatRoomUser->user->name];
                }
            } 
            
            //利用者も同様に処理する
            else if($chatRoomUser->user->user_type_id == 2) {
                if(isset($users[$chatRoomUser->user->office_id])) {
                    array_push($users[$chatRoomUser->user->office_id], $chatRoomUser->user->name);
                } else {
                    $users[$chatRoomUser->user->office_id] = [$chatRoomUser->user->name];
                }
            }

            //体験者を$trialsに入れる
            else {
                $trials[] = $chatRoomUser->user->name;
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
                                                    <a href="{{ route('chat.show', $joinRoom->id) }}">{{ $office->name }}職員</a>
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
                            <button type="button" class="btn btn-outline-dark btn-block" id="sub-offices" data-toggle="collapse" data-target="#subOffices" aria-expanded="false" aria-controls="subOffices">
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
                                                            <a href="{{ route('chat.show', $joinRoom->id) }}">{{ $office->name }}職員</a>
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
        <div class="col-md-8 bg-white border-top border-dark p-0">
            <button type="button" class="btn btn-dark rounded-circle position-fixed mt-5 d-block d-md-none sidebar-open" id="left-open" data-toggle="modal" data-target="#left-modal">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="modal fade" id="left-modal" tabindex="-1">
                <div class="modal-dialog">
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
                                                                <a href="{{ route('chat.show', $joinRoom->id) }}">{{ $office->name }}職員</a>
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
                                        <button type="button" class="btn btn-outline-dark btn-block" id="sub-offices" data-toggle="collapse" data-target="#subOffices" aria-expanded="false" aria-controls="subOffices">
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
                                                                        <a href="{{ route('chat.show', $joinRoom->id) }}">{{ $office->name }}職員</a>
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
                    <div class="modal-dialog">
                        <div class="modal-content h-100">
                            <div class="modal-body">
                                <div class="row">
                                    <h5 class="col-12 pt-3">参加者 - {{ $chatRoomUsers->count() }}人</h5>
                                </div>
                                <div class="row">
                                    @foreach ($offices as $office)
                                        @if (isset($officers[$office->id]))
                                            <div>
                                                <h5 class="col-12 pt-3">{{ $office->office_name }}職員 - {{ count($officers[$office->id]) }}人</h5>
                                                <ul class="col-12 pt-1">
                                                    @foreach ($officers[$office->id] as $officer)
                                                        <li>{{ $officer }}</li>
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
                                                <h5 class="col-12 pt-3">{{ $office->office_name }}通所者 - {{ count($users[$office->id]) }}人</h5>
                                                <ul class="col-12 pt-1">
                                                    @foreach ($users[$office->id] as $user)
                                                        <li>{{ $user }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row">
                                    @if (isset($trials[0]))
                                        <h5 class="col-12 pt-3">体験者 - {{ count($trials) }}人</h5>
                                        <ul class="col-12 pt-1">
                                            @foreach ($trials as $trial)
                                                <li>{{ $trial }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="scroll-contents" id="center-scroll">
                @yield('center')
            </div>
            @yield("c_modal")
        </div>
        <div class="col-md-2 d-none d-md-block border border-dark pr-0">
            <div class="scroll-contents">
                @if (isset($chat_room))
                    <div class="row">
                        <h5 class="col-12 pt-3">参加者 - {{ $chatRoomUsers->count() }}人</h5>
                    </div>
                    <div class="row">
                        @foreach ($offices as $office)
                            @if (isset($officers[$office->id]))
                                <div>
                                    <h5 class="col-12 pt-3">{{ $office->office_name }}職員 - {{ count($officers[$office->id]) }}人</h5>
                                    <ul class="col-12 pt-1">
                                        @foreach ($officers[$office->id] as $officer)
                                            <li>{{ $officer }}</li>
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
                                    <h5 class="col-12 pt-3">{{ $office->office_name }}通所者 - {{ count($users[$office->id]) }}人</h5>
                                    <ul class="col-12 pt-1">
                                        @foreach ($users[$office->id] as $user)
                                            <li>{{ $user }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="row">
                        @if (isset($trials[0]))
                            <h5 class="col-12 pt-3">体験者 - {{ count($trials) }}人</h5>
                            <ul class="col-12 pt-1">
                                @foreach ($trials as $trial)
                                    <li>{{ $trial }}</li>
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
{{-- jQuery読み込み --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
    $(function() {

        //#sub-officesが押された時の動作
        $("#sub-offices").click(function(){
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