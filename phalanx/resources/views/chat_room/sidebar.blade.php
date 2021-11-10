<?php
//$chat_roomが渡されているとき参加者の情報を取得
if(isset($chat_room)) {
    $chatRoomUsers = $chat_room->chat_room__user->whereNull("deleted_at");
    if(isset($chatRoomUsers)) {
        $officers = [];
        $users = [];
        foreach($chatRoomUsers as $chatRoomUser) {
            if($chatRoomUser->user->user_type_id == 1) {
                if(isset($officers[$chatRoomUser->user->office_id])) {
                    arary_push($officers[$chatRoomUser->user->office_id], $chatRoomUser->user);
                } else {
                    $officers = [$chatRoomUser->user->office_id => $chatRoomUser->user];
                }
            } else {
                if(isset($users[$chatRoomUser->user->office_id])) {
                    arary_push($users[$chatRoomUser->user->office_id], $chatRoomUser->user);
                } else {
                    $users = [$chatRoomUser->user->office_id => $chatRoomUser->user];
                }
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
        <div class="col-md-2 d-none d-md-block border border-dark">
            <div class="sticky-top">
                @if (Auth::user()->user_type_id == 1)
                    <div class="row p-3">
                        <a href="{{ route('chat_room.index') }}" class="btn btn-primary btn-lg btn-block" role="button">通所者一覧</a>
                    </div>
                @endif
                <div class="row">
                    @if (isset($group))
                        <div class="col-12 pt-3">
                            <h5>リテラル</h5>
                            <ul style="list-style: none">
                                <li><a href="{{ route("chat_room.show", $group->id) }}">全職員</a></li>
                            </ul>
                        </div>
                    @endif
                    @foreach ($offices as $office)
                        @if ($office->id == Auth::user()->office_id)
                            <div class="col-12 pt-3">
                                <h5>{{ $office->office_name }}</h5>
                                <ul>
                                    @foreach ($joinRooms as $joinRoom)
                                        @if ($joinRoom->office_id == $office->id)
                                            <li>
                                                @if ($joinRoom->distinction_number == 4)
                                                    <a href="{{ route('chat_room.show', $joinRoom->id) }}">{{ $joinRoom->room_title }}</a>
                                                @else
                                                    <a href="{{ route('chat_room.show', $joinRoom->id) }}">{{ $office->name }}職員</a>
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
                            <button type="button" class="btn btn-outline-dark btn-block" data-toggle="collapse" data-target="#subOffices" aria-expanded="false" aria-controls="subOffices">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <div class="collapse" id="subOffices">
                            @foreach ($offices as $office)
                                @if ($office->id != Auth::user()->office_id)
                                    <div class="col-12 pt-3">
                                        <h5>{{ $office->office_name }}</h5>
                                        <ul>
                                            @foreach ($joinRooms as $joinRoom)
                                                @if ($joinRoom->office_id == $office->id)
                                                    <li>
                                                        @if ($joinRoom->distinction_number == 4)
                                                            <a href="{{ route('chat_room.show', $joinRoom->id) }}">{{ $joinRoom->room_title }}</a>
                                                        @else
                                                            <a href="{{ route('chat_room.show', $joinRoom->id) }}">{{ $office->name }}職員</a>
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
        <div class="col-md-8 bg-white">
            @yield('center')
        </div>
        <div class="col-md-2 d-none d-md-block border border-dark">
            <div class="sticky-top">
                @if (isset($chat_room))
                    <div class="row">
                        <h5 class="col-12 pt-3">参加者 - {{ $chatRoomUsers->count() }}人</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection