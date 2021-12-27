@extends('layouts.app')

@section("title", "予定通知管理　一覧")
@section('css')
    <link href="{{ asset('css/index-table.css') }}" rel="stylesheet">
    <link href="{{ asset('css/notification/index.css') }}" rel="stylesheet">
@endsection
@section('content')

    <div class="container">
        <h3>予定通知管理　一覧</h3>
        <a href="{{ route('notification.create') }}" type="button" class="btn btn-primary">新規作成</a>
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr class="table-header">
                    <th class="table-header-sub">作成日時</th>
                    <th class="table-header-sub">開始日時</th>
                    <th class="table-header-sub">終了日時</th>
                    <th>内容</th>
                    <th class="table-header-sub">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notifications as $notification)
                    <tr>
                        <td>{{ $notification->created_at }}</td>
                        <td>{{ $notification->start_date_format() }}</td>
                        <td>{{ $notification->end_date_format() }}</td>
                        <td>{{ mb_substr($notification->content, 0, 32) }}</td>
                        <td>
                            <div class="table-body-action">
                                <span>
                                    <a href="{{ route('notification.edit', $notification->id) }}" type="button"
                                        class="btn btn-sm btn-primary edit-button">編集
                                    </a>
                                </span>
                                <form action="{{ route('notification.destroy', $notification->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger delete-button"
                                        onclick="return confirm('削除しますか\nID: {{ $notification->id }}\n作成日時: {{ $notification->created_at }}\n開始日時: {{ $notification->start_at }}\n終了日時: {{ $notification->end_at }}\n内容: {{ mb_substr($notification->content, 0, 32) }}')">
                                    削除</button>
                                </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $notifications->links('vendor/pagination/pagination_view') }}

    </div>
@endsection
