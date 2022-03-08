@extends('layouts.app')
@section("title", "チャットルーム管理　編集")
@section('css')
<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
@endsection

@section('content')
<div class="container-md">
    <h3 class="page_title">チャットルーム管理　編集</h3>
    <form action="{{ route('chat_room.update', $chatRoom->id) }}" method="post" class="mt-3">
        @csrf
        @method("PATCH")
        <div class="row">
            <div class="col-sm mt-3 mx-3 px-0 d-flex flex-column">
                <label for="roomTitle">ルーム名</label>
                <input type="text" class="form-control" id="roomTitle" name="room_title" value="{{ old('room_title', $chatRoom->room_title) }}">
                @if ($errors->has("room_title"))
                    <ul class="pl-0 mt-1" style="list-style: none">
                        @foreach ($errors->get("room_title") as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="col-sm m-3 px-0 d-flex flex-column">
                <label for="officeName">事業所</label>
                <select name="office_id" id="officeName" class="custom-select">
                    <option value="">選択してください</option>
                    @foreach ($offices as $office)
                        <option value="{{ $office->id }}"
                            @if (old("office_id", $chatRoom->office_id) == $office->id) selected @endif>
                            {{ $office->office_name }}
                        </option>
                    @endforeach
                    <option value="0" @if (old("office_id", $chatRoom->office_id) == 0) selected @endif>その他</option>
                </select>
                @if ($errors->has("office_id"))
                    <ul class="pl-0 mt-1" style="list-style: none">
                        <li class="text-danger">事業所を選択してください。</li>
                    </ul>
                @endif
            </div>
        </div>
        <div class="d-flex flex-column">
            <div class="row">
                <div class="col-sm-auto mt-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#peopleListModal" data-target-group="staff">メンバー選択（職員）</button>
                </div>
                <div class="col-sm-auto mt-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#peopleListModal" data-target-group="user">メンバー選択（利用者）</button>
                </div>
            </div>
            <div class="mx-0 mt-2 insert-checked-people"></div>
            @if ($errors->has("target_users"))
                <ul class="pl-0 mt-1" style="list-style: none">
                    <li class="text-danger">メンバーを選択してください。</li>
                </ul>
            @endif
        </div>
        <input name="target_users" id="target_users" hidden>
        <div class="d-flex flex-row mt-3">
            <button class="btn btn-primary" type="submit">登録</button>
            <button class="btn btn-secondary ml-3" type="submit" form="cancelButton" onclick="return confirm('作成を中止しますか？')">キャンセル</button>
        </div>
    </form>
    <form action="{{ route('chat_room.index') }}" method="get" id="cancelButton"></form>
</div>
@endsection

@section('script')
@include("component.people_list")
@endsection