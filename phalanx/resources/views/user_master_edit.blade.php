@extends('layouts.app')
@section('content')

<!--=============
    先に見た目だけ
===============-->

<div class="container">
    <h3>ユーザーマスター　編集</h3>
    <form>
        <div class="form-group">
            <div class="row justify-content-start mx-auto my-4">
                <div style="width: 33%">
                    <label for="name" style="width: 100px;" class="text-md-left">氏名</label><br />
                    <input type="text" id="name" style="width: 100px;" class="form-select">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div style="width: 33%">
                    <label for="name_katakana" style="width: 100px;" class="text-md-left">氏名（カナ）</label><br />
                    <input type="text" id="name_katakana" style="width: 100px;" class="form-select">
                    @error('name_katakana')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row justify-content-start mx-auto my-4">
                <div style="width: 33%">
                    <label for="user_type" style="width: 100px;" class="text-md-left">ユーザー種別</label><br />
                    <select id="user_type" style="width: 100px;" class="form-select">
                        <option value="" selected>条件なし</option>
                        <option value="1">職員</option>
                        <option value="2">利用者</option>
                    </select>
                    @error('user_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div style="width: 33%">
                    <label for="office" style="width: 100px;" class="text-md-left">事業所</label><br />
                    <select id="office" style="width: 100px;" class="form-select">
                        <option value="" selected>条件なし</option>
                        <option value="1">アップル梅田</option>
                        <option value="2">ミント大阪</option>
                        <option value="3">メイプル関西</option>
                    </select>
                    @error('office')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row justify-content-start mx-auto my-4">
                <div style="width: 33%">
                    <label for="login_name" style="width: 100px;" class="text-md-left">ログイン名</label><br />
                    <input type="text" id="login_name" style="width: 100px;" class="form-select">
                    @error('login_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div style="width: 33%">
                    <label for="password" style="width: 100px;" class="text-md-left">パスワード</label><br />
                    <input type="text" id="password" style="width: 100px;" class="form-select">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div style="width: 33%">
                    <label for="password-confirm" style="width: 200px;" class="text-md-left">パスワード（再入力）</label><br />
                    <input type="text" id="password-confirm" style="width: 100px;" class="form-select">
                    @error('password-confirm')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <input type="submit" class="btn btn-primary" value="更新"><a href="#" style="margin-left: 100px;"class="btn btn-secondary">戻る</a>
    </form>
</div>

@endsection