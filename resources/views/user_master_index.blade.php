@extends('layouts.app')
@section('content')

<!--=============
    先に見た目だけ
===============-->

<div class="container">
    <h3>ユーザーマスター　一覧</h3>
    <form method="get" action="{{ route('user.index') }}">
        <div class="form-group">
            <div class="row justify-content-start mx-auto my-2">
                <label for="user_type" style="width: 100px;" class="text-md-left">ユーザー種別</label>
                <select id="user_type" name="user_type" style="width: 100px;" class="form-select">
                    <option value="" selected>条件なし</option>
                    @foreach ($user_types as $user_type)
                        <option value="{{ $user_type->id }}">{{ $user_type->alias }}</option>
                    @endforeach
                </select>
                <div class="col2"></div>
            </div>
            <div class="row justify-content-start mx-auto my-2">
                <label for="office" style="width: 100px;" class="text-md-left">事業所</label>
                <select id="office" name="office" style="width: 100px;" class="form-select">
                    <option value="" selected>条件なし</option>
                    @foreach ($offices as $office)
                        <option value="{{ $office->id }}">{{ $office->office_name }}</option>
                    @endforeach
                </select>
                <input type="submit" style="margin-left: 50px;" class="text-md-right" value="絞り込み">
            </div>
        </div>
    </form>
    <a href="#" type="button" class="btn btn-primary" style="margin: 10px;">新規作成</a>
    <table class="table table-striped table-bordered">
        <thead>
            <tr><th>氏名</th><th>ユーザー種別</th><th>事業所</th><th>操作</th></tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr><td>{{ $user->name }}</td><td>{{ $user->user_type->alias }}</td><td>{{ $user->office->office_name }}</td><td><a href="#" type="button" class="btn btn-primary" style="margin: auto 10px;">編集</a><form style="display: inline;"><input hidden value="1"><input type="submit" value="削除" class="btn btn-danger"></form></td></tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection