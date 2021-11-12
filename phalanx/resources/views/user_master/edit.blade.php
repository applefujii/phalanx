@extends('layouts.app')
@section('css')
<link href="{{ asset('css/user-master/create_and_edit.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container">
    <h3>ユーザーマスター　編集</h3>
    <form method="post" action="{{ route('user.update', $user->id) }}">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <div class="row justify-content-start mx-auto my-4">
                <div class="mx-4">
                    <label for="name" class="text-md-left form-element">氏名</label><br />
                    <input type="text" id="name" class="form-control form-element @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mx-4">
                    <label for="name_katakana" class="text-md-left">氏名（カナ）</label><br />
                    <input type="text" id="name_katakana"  class="form-control form-element @error('name_katakana') is-invalid @enderror" name="name_katakana" value="{{ old('name_katakana', $user->name_katakana) }}">
                    @error('name_katakana')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row justify-content-start mx-auto my-4">
                <div class="mx-4">
                    <label for="user_typeid" class="text-md-left form-element">ユーザー種別</label><br />
                    <select id="user_typeid" class="form-control form-element @error('user_type_id') is-invalid @enderror" name="user_type_id">
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
                <div class="mx-4">
                    <label for="office_id" class="text-md-left form-element">事業所</label><br />
                    <select id="office_id"  class="form-control form-element @error('office_id') is-invalid @enderror" name="office_id">
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
                <div class="mx-4">
                    <label for="login_name" class="text-md-left form-element">ログイン名</label><br />
                    <input type="text" id="login_name" class="form-control form-element @error('login_name') is-invalid @enderror" name="login_name" value="{{ old('login_name', $user->login_name) }}">
                    @error('login_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="information">
                        <span>半角英数字または_(アンダースコア)が使用できます</span><br />
                        <span>3字以上 30字以内で入力してください。</span>
                    </div>
                </div>
                <div class="mx-4">
                    <label for="password" class="text-md-left form-element">パスワード</label><br />
                    <input type="password" id="password" class="form-control form-element @error('password') is-invalid @enderror" name="password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="information">
                        <span>半角英数字記号が使用できます</span><br />
                        <span>8字以上 30字以内で入力してください。</span>
                    </div>
                </div>
                <div class="mx-4">
                    <label for="password-confirm" class="text-md-left form-element">パスワード（再入力）</label><br />
                    <input type="password" id="password-confirm" class="form-control form-element" name="password_confirmation">
                </div>
            </div>
        </div>

        <input type="submit" class="btn btn-primary" value="更新"><a href="{{ route('user.index') }}" class="btn btn-secondary back-button">戻る</a>
    </form>
</div>

@endsection