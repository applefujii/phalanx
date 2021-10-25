@extends('layouts.app')
@section('content')

<!--=============
    先に見た目だけ
===============-->

<div class="container">
    <h3>ユーザーマスター　一覧</h3>
    <form>
        <div class="form-group">
            <div class="row justify-content-start mx-auto my-2">
                <label for="user-type" style="width: 100px;" class="text-md-left">ユーザー種別</label>
                <select id="user-type" style="width: 100px;" class="form-select">
                    <option value="" selected>条件なし</option>
                    <option value="1">職員</option>
                    <option value="2">利用者</option>
                </select>
                <div class="col2"></div>
            </div>
            <div class="row justify-content-start mx-auto my-2">
                <label for="office" style="width: 100px;" class="text-md-left">事業所</label>
                <select id="office" style="width: 100px;" class="form-select">
                    <option value="" selected>条件なし</option>
                    <option value="1">アップル梅田</option>
                    <option value="2">ミント大阪</option>
                    <option value="3">メイプル関西</option>
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
            <tr><td>氏名</td><td>ユーザー種別</td><td>事業所</td><td><a href="#" type="button" class="btn btn-primary" style="margin: auto 10px;">編集</a><form style="display: inline;"><input hidden value="1"><input type="submit" value="削除" class="btn btn-danger"></form></td></tr>
            <tr><td>氏名</td><td>ユーザー種別</td><td>事業所</td><td><a href="#" type="button" class="btn btn-primary" style="margin: auto 10px;">編集</a><form style="display: inline;"><input hidden value="2"><input type="submit" value="削除" class="btn btn-danger"></form></td></tr>
            <tr><td>氏名</td><td>ユーザー種別</td><td>事業所</td><td><a href="#" type="button" class="btn btn-primary" style="margin: auto 10px;">編集</a><form style="display: inline;"><input hidden value="3"><input type="submit" value="削除" class="btn btn-danger"></form></td></tr>
            <tr><td>氏名</td><td>ユーザー種別</td><td>事業所</td><td>操作</td></tr>
            <tr><td>氏名</td><td>ユーザー種別</td><td>事業所</td><td>操作</td></tr>
            <tr><td>氏名</td><td>ユーザー種別</td><td>事業所</td><td>操作</td></tr>
            <tr><td>氏名</td><td>ユーザー種別</td><td>事業所</td><td>操作</td></tr>
        </tbody>
    </table>
</div>
@endsection