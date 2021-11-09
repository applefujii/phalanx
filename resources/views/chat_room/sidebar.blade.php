<?php
//$chatRoomが渡されているとき参加者の情報を取得
if(isset($chatRoom)) {
    $chatRoomUsers = $chatRoom->chat_room__user->whereNull("deleted_at");
    $officers = [];
    $users = [];
    foreach($chatRoomUsers as $chatRoomUser) {
        
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
        <div class="col-md-2 d-none d-md-block border border-dark left_sidebar">
            @if (Auth::user()->user_type_id == 1)
                <div class="row p-3">
                    <a href="{{ route('chat_room.index') }}" class="btn btn-primary btn-lg btn-block" role="button">通所者一覧</a>
                </div>
            @endif
            <div class="row">
                @if (isset($group))
                    <div class="row">
                        <p>リテラル</p>
                        <ul style="list-style: none">
                            <li><a href="{{ route("chat_room.show", $group->id) }}">全職員</a></li>
                        </ul>
                    </div>
                @endif
                @foreach ($offices as $office)
                    @if ($office->id == Auth::user()->office_id)
                        <div class="col-12">
                            <p>{{ $office->office_name }}</p>
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
                    <div class="p-0">
                        <button type="button" class="btn btn-outline-dark btn-block" data-toggle="collapse" data-target="#subOffices" aria-expanded="false" aria-controls="subOffices">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse" id="subOffices">
                        @foreach ($offices as $office)
                            @if ($office->id != Auth::user()->office_id)
                                <div class="col-12">
                                    <p class="pt-3">{{ $office->office_name }}</p>
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
        <div class="col-md-8 bg-white">
            @yield('center')
        </div>
        <div class="col-md-2 d-none d-md-block border border-dark">
            @if (isset($chatRoom))
                <div class="row">
                    <p>参加者 - {{ count($chatRoom->chatRoom__User) }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection