@extends('layouts.app')

@section('title', 'ユーザーマスター　一覧')
@section('css')
    <link href="{{ asset('css/index-table.css') }}" rel="stylesheet">
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
        <a href="{{ route('user.create') }}" type="button" class="btn btn-primary">新規作成</a>
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr class="table-header">
                    <th style="width: 50%">氏名</th>
                    <th class="table-header-sub" style="width: 15%">ユーザー種別</th>
                    <th class="table-header-sub" style="width: 15%">事業所</th>
                    <th class="table-header-sub" style="width: 20%">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="main-td">{{ $user->name }}</td>
                        <td>{{ $user->user_type->alias }}</td>
                        <td>{{ $user->office->office_name }}</td>
                        <td>
                            <div class="table-body-action"><span><a href="{{ route('user.edit', $user->id) }}"
                                        type="button" class="btn btn-sm btn-primary edit-button">編集</a></span>
                                <form method="post" action="{{ route('user.destroy', $user->id) }}"> @csrf
                                    @method('DELETE') <button type="submit"
                                        class="btn btn-sm btn-danger delete-button" onclick='@if($user->id == Auth::id()) alert("自身のアカウントを削除できないように制限しています"); return false; @else return confirm("削除しますか\nID: {{ $user->id }}\n名前: {{ $user->name }}\nユーザー種別: {{ $user->user_type->alias }}\n事業所: {{ $user->office->office_name }}"); @endif'>削除</button></form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $users->links('vendor/pagination/pagination_view') }}

    </div>
@endsection
