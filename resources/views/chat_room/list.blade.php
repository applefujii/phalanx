<?php
$chatRoomsChunk = array_chunk($chatRooms, 20);
?>

@extends('layouts.app')
@section('content')
<h3 class="page_title">チャットルーム管理　一覧</h3>
<div class="container-md">
    <form action="{{ route('chat_rooms.create') }}" method="GET">
        <button class="btn btn-info" type="submit">新規作成</button>
    </form>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="thead-info">
                <tr>
                    <th class="col-4">ルーム名</th>
                    <th class="col-4">事業所</th>
                    <th class="col-8">操作</th>
                </tr>
            </thead>
            @for ($i = 0; $i < count($chatRoomsChunk); $i++)
                <tbody class="d-none">
                    @foreach ($chatRoomsChunk[$i] as $chatRoom)
                        <tr>
                            <td>{{ $chatRoom->room_title }}</td>
                            <td>{{ $chatRoom->office->office_name }}</td>
                            <td>
                                <div class="row">
                                    <div class="col">
                                        <form action="{{ route('chat_rooms.edit', $chatRoom->id) }}" method="GET">
                                            <button class="btn btn-primary" type="submit">編集</button>
                                        </form>
                                    </div>
                                    <div class="col">
                                        <form action="{{ route('chat_rooms.destroy', $chatRoom->id) }}" method="POST">
                                            @csrf
                                            @method("DELETE")
                                            <button class="btn btn-danger" type="submit">削除</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @endfor
        </table>
    </div>
    <div class="text-right">
        
    </div>
</div>
@endsection