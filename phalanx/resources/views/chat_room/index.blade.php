@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/chat_room_index.css') }}">
@endsection
@section('content')
<div class="container-md">
    <h3 class="page_title">チャットルーム管理　一覧</h3>
    <form action="{{ route('chat_room.create') }}" method="GET" class="mt-3">
        <button class="btn btn-primary my-3" type="submit">新規作成</button>
    </form>
    <div class="mt-3">
        <table class="table table-striped table-bordered border-white">
            <thead class="bg-primary text-white">
                <tr class="text-center">
                    <th class="col-3 align-middle">ルーム名</th>
                    <th class="col-3 align-middle">事業所</th>
                    <th class="col-6 align-middle">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chatRooms as $chatRoom)
                    <tr>
                        <td class="room-title align-middle">{{ $chatRoom->room_title }}</td>
                        <td class="align-middle">{{ $chatRoom->office->office_name }}</td>
                        <td class="align-middle">
                            <div class="row gx-2 text-center">
                                <div class="col">
                                    <form action="{{ route('chat_room.edit', $chatRoom->id) }}" method="GET">
                                        <button class="btn btn-primary" type="submit">編集</button>
                                    </form>
                                </div>
                                <div class="col">
                                    <form action="{{ route('chat_room.destroy', $chatRoom->id) }}" method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <button class="btn btn-danger" type="submit" onclick="return confirm('本当に削除しますか？')">削除</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-2">
        {{ $chatRooms->links() }}
    </div>
</div>
@endsection