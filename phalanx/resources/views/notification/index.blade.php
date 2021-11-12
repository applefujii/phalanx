@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/index-table.css') }}" rel="stylesheet">
    <link href="{{ asset('css/notification/index.css') }}" rel="stylesheet">
@endsection
@section('content')

    <div class="container">
        <h3>予定通知　一覧</h3>
        <form method="get" action="{{ route('notification.index') }}">
            <div class="form-group">
                <div class="row justify-content-start mx-auto my-2">
                    <label for="user_type" class="text-md-left label">ユーザー種別</label>
                    <select id="user_type" name="user_type" class="form-select">
                        <option value="" @if ($filter_user_type_id === '') selected @endif>条件なし</option>
                        @foreach ($user_types as $user_type)
                            <option value="{{ $user_type->id }}" @if ($filter_user_type_id == $user_type->id) selected @endif>{{ $user_type->alias }}
                            </option>
                        @endforeach
                    </select>
                    <div class="col2"></div>
                </div>
                <div class="row justify-content-start mx-auto my-2">
                    <label for="office" class="text-md-left label">事業所</label>
                    <select id="office" name="office" class="form-select">
                        <option value="" @if ($filter_office_id === '') selected @endif>条件なし</option>
                        @foreach ($offices as $office)
                            <option value="{{ $office->id }}" @if ($filter_office_id == $office->id) selected @endif>{{ $office->office_name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="submit" class="text-md-right filter-button" value="絞り込み">
                </div>
            </div>
        </form>
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
                        <td>{{ $notification->start_at }}</td>
                        <td>{{ $notification->end_at }}</td>
                        <td>{{ $notification->content }}</td>
                        <td>
                            <div class="table-body-action">
                                <span>
                                    <a href="{{ route('notification.edit', $notification->id) }}" type="button"
                                        class="btn btn-sm btn-primary edit-button">編集
                                    </a>
                                </span>
                                <form>
                                    <input hidden value="1">
                                    <button type="submit" class="btn btn-sm btn-danger delete-button">削除
                                    </button>
                                </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $notifications->links('pagination::bootstrap-4') }}

    </div>
@endsection
