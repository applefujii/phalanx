@extends('layouts.app')

@section('css')
<link href="{{ asset('css/user-master/index.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container">
    <h3>ユーザーマスター　一覧</h3>
    <form method="get" action="{{ route('user.index') }}">
        <div class="form-group">
            <div class="row justify-content-start mx-auto my-2">
                <label for="user_type" class="text-md-left label">ユーザー種別</label>
                <select id="user_type" name="user_type" class="form-select">
                    <option value="" @if($filter_user_type_id === '') selected @endif>条件なし</option>
                    @foreach ($user_types as $user_type)
                        <option value="{{ $user_type->id }}" @if($filter_user_type_id == $user_type->id) selected @endif>{{ $user_type->alias }}</option>
                    @endforeach
                </select>
                <div class="col2"></div>
            </div>
            <div class="row justify-content-start mx-auto my-2">
                <label for="office" class="text-md-left label">事業所</label>
                <select id="office" name="office" class="form-select">
                    <option value="" @if($filter_office_id === '') selected @endif>条件なし</option>
                    @foreach ($offices as $office)
                        <option value="{{ $office->id }}" @if($filter_office_id == $office->id) selected @endif>{{ $office->office_name }}</option>
                    @endforeach
                </select>
                <input type="submit" class="text-md-right filter-button" value="絞り込み">
            </div>
        </div>
    </form>
    <a href="{{ route('user.create') }}" type="button" class="btn btn-primary">新規作成</a>
    <table class="table table-striped table-bordered table-sm">
        <thead>
            <tr class="table-header"><th class="table-header-username">氏名</th><th class="table-header-usertype">ユーザー種別</th><th class="table-header-office">事業所</th><th class="table-header-action">操作</th></tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr><td>{{ $user->name }}</td><td>{{ $user->user_type->alias }}</td><td>{{ $user->office->office_name }}</td><td><div class="table-body-action"><a href="{{ route('user.edit', $user->id) }}" type="button" class="btn btn-primary edit-button">編集</a><form method="post" action="{{ route('user.destroy', $user->id) }}" class="delete-form"> @csrf @method('DELETE') <input type="submit" value="削除" class="btn btn-danger delete-button"></form></td></tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links('pagination::bootstrap-4') }}

</div>
@endsection