@extends('layouts.app')
@section("title", "チャットルーム管理　一覧")
@section('css')
<!-- <link href="{{ asset('css/chat_room_index.css') }}" rel="stylesheet"> -->
<link href="{{ asset('css/office-table.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container-md">
    <h3 class="page_title">チャットルーム管理　一覧</h3>
    <form action="{{ route('chat_room.create') }}" method="GET" class="mt-3">
        <button class="btn btn-primary my-3" type="submit">新規作成</button>
    </form>
    <div class="mt-3">
        <table class="table table-striped table-bordered border-white table-sm w-100">
            <thead class="w-100">
                <tr class="table-header w-100">
                    <th class="col-6 align-middle">ルーム名</th>
                    <th class="col-3 align-middle">事業所</th>
                    <th class="col-3 align-middle">操作</th>
                </tr>
            </thead>
            <tbody class="w-100">
                @foreach ($chatRooms as $chatRoom)
                    <tr class="w-100">
                        <td class="room-title align-middle col-6">{{ $chatRoom->room_title }}</td>
                        <td class="align-middle col-3">
                            @if ($chatRoom->office_id == 0)
                                その他
                            @else
                                {{ $chatRoom->office->office_name }}
                            @endif
                        </td>
                        <td class="align-middle col-3">
                            <div class="table-body-action">
                                <form action="{{ route('chat_room.edit', $chatRoom->id) }}" method="GET">
                                    <button class="btn btn-sm btn-primary" type="submit">編集</button>
                                </form>
                                <form action="{{ route('chat_room.destroy', $chatRoom->id) }}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('削除しますか\nID: {{ $chatRoom->id }}\nルーム名: {{ $chatRoom->room_title }}\n事業所: @if(isset($chatRoom->office)){{ $chatRoom->office->office_name }}@elseその他@endif')">
                                    削除</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-2">
        {{ $chatRooms->links('vendor/pagination/pagination_view') }}
    </div>
</div>
@endsection