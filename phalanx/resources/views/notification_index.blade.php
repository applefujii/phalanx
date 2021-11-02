@extends('layouts.app')
@section('content')

{{ old('office') }}
<div class="container">
    <h3>予定通知　一覧</h3>
    <form method="get" action="{{ route('notification.index') }}">
        <div class="form-group">
            <div class="row justify-content-start mx-auto my-2">
                <label for="user_type" style="width: 100px;" class="text-md-left">ユーザー種別</label>
                <select id="user_type" name="user_type" style="width: 100px;" class="form-select">
                    <option value="" @if($filter_user_type_id === '') selected @endif>条件なし</option>
                    @foreach ($user_types as $user_type)
                        <option value="{{ $user_type->id }}" @if($filter_user_type_id == $user_type->id) selected @endif>{{ $user_type->alias }}</option>
                    @endforeach
                </select>
                <div class="col2"></div>
            </div>
            <div class="row justify-content-start mx-auto my-2">
                <label for="office" style="width: 100px;" class="text-md-left">事業所</label>
                <select id="office" name="office" style="width: 100px;" class="form-select">
                    <option value="" @if($filter_office_id === '') selected @endif>条件なし</option>
                    @foreach ($offices as $office)
                        <option value="{{ $office->id }}" @if($filter_office_id == $office->id) selected @endif>{{ $office->office_name }}</option>
                    @endforeach
                </select>
                <input type="submit" style="margin-left: 50px;" class="text-md-right" value="絞り込み">
            </div>
        </div>
    </form>
    <a href="#" type="button" class="btn btn-primary" style="margin: 10px;">新規作成</a>
    <table class="table table-striped table-bordered table-sm">
        <thead>
            <tr style="font-size: 120%; background-color: MidnightBlue ; color: white;"><th style="width: 30%">作成日時</th><th style="width: 25%">開始日時</th><th style="width: 25%">終了日時</th><th style="width: 25%">内容</th><th style="width: 20%">操作</th></tr>
        </thead>
        <tbody>
            @foreach($notifications as $notification)
                <tr>
                    <td>{{ $notification->created_at }}</td>
                    <td>{{ $notification->start_at }}</td>
                    <td>{{ $notification->end_at }}</td>
                    <td>{{ $notification->content }}</td>
                    <td><div style="text-align: center"><a href="#" type="button" class="btn btn-primary" style="margin-right: 13%; max-width: 30%; min-width: 40px; display: inline;">編集</a><form style="display: inline;"><input hidden value="1"><input type="submit" value="削除" class="btn btn-danger" style="max-width: 30%; min-width: 40px; white-space: normal;"></form></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $notifications->links('pagination::bootstrap-4') }}

</div>
@endsection