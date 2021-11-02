@extends('layouts.app')
@section('content')
<h3 class="page_title">チャットルーム管理　一覧</h3>
<div class="container-md">
    <form action="{{ route('chat_rooms.create') }}" method="GET">
        <button class="btn btn-info" type="submit">新規作成</button>
    </form>
    <div class="table-responsive">
        <table class="table table-striped table-bordered border-white">
            <thead class="thead-info">
                <tr>
                    <th>ルーム名</th>
                    <th>事業所</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chatRooms as $chatRoom)
                    <tr>
                        <td>{{ $chatRoom->room_title }}</td>
                        <td>{{ $chatRoom->office->office_name }}</td>
                        <td>
                            <div class="row">
                                <div class="col mr-2">
                                    <form action="{{ route('chat_rooms.edit', $chatRoom->id) }}" method="GET">
                                        <button class="btn btn-primary" type="submit">編集</button>
                                    </form>
                                </div>
                                <div class="col">
                                    <form action="{{ route('chat_rooms.destroy', $chatRoom->id) }}" method="POST">
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
    <div class="text-right">
        {{ $chatRooms->links() }}
    </div>
</div>
@endsection