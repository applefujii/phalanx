@extends('layouts.app')
@section('content')

<!--=============
    先に見た目だけ
===============-->

<div class="container">
    <h3>ユーザーマスター　編集</h3>
    <form method="post" action="{{ route('user.update', $user->id) }}">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <div class="row justify-content-start mx-auto my-4">
                <div style="width: 33%">
                    <label for="name" style="width: 200px;" class="text-md-left">氏名</label><br />
                    <input type="text" id="name" style="width: 200px;" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div style="width: 33%">
                    <label for="name_katakana" style="width: 200px;" class="text-md-left">氏名（カナ）</label><br />
                    <input type="text" id="name_katakana" style="width: 200px;" class="form-control @error('name_katakana') is-invalid @enderror" name="name_katakana" value="{{ old('name_katakana', $user->name_katakana) }}" required>
                    @error('name_katakana')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row justify-content-start mx-auto my-4">
                <div style="width: 33%">
                    <label for="user_typeid" style="width: 200px;" class="text-md-left">ユーザー種別</label><br />
                    <select id="user_typeid" style="width: 200px;" class="form-control @error('user_type_id') is-invalid @enderror" name="user_type_id" required>
                        @foreach ($user_types as $user_type)
                            <option value="{{ $user_type->id }}" @if ($user_type->id == old('user_type_id', $user->user_type_id)) selected @endif>{{ $user_type->alias }}</option>
                        @endforeach
                    </select>
                    @error('user_type_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div style="width: 33%">
                    <label for="office_id" style="width: 200px;" class="text-md-left">事業所</label><br />
                    <select id="office_id" style="width: 200px;" class="form-control @error('office_id') is-invalid @enderror" name="office_id" required>
                        @foreach ($offices as $office)
                            <option value="{{ $office->id }}" @if ($office->id == old('office_id', $user->office_id)) selected @endif>{{ $office->office_name }}</option>
                        @endforeach
                    </select>
                    @error('office_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row justify-content-start mx-auto my-4">
                <div style="width: 33%">
                    <label for="login_name" style="width: 200px;" class="text-md-left">ログイン名</label><br />
                    <input type="text" id="login_name" style="width: 200px;" class="form-control @error('login_name') is-invalid @enderror" name="login_name" value="{{ old('login_name', $user->login_name) }}" required>
                    @error('login_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div style="width: 33%">
                    <label for="password" style="width: 200px;" class="text-md-left">パスワード</label><br />
                    <input type="password" id="password" style="width: 200px;" class="form-control @error('password') is-invalid @enderror" name="password" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div style="width: 33%">
                    <label for="password-confirm" style="width: 200px;" class="text-md-left">パスワード（再入力）</label><br />
                    <input type="password" id="password-confirm" style="width: 200px;" class="form-control" name="password_confirmation" required>
                </div>
            </div>
        </div>

        <input type="submit" class="btn btn-primary" value="更新"><a href="{{ route('user.index') }}" style="margin-left: 200px;"class="btn btn-secondary">戻る</a>
    </form>
</div>

@endsection