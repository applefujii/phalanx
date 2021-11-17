@extends('layouts.app')
@section('css')
<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
@endsection

@section('content')
<div class="container-md">
    <h3 class="page_title">チャットルーム管理　新規作成</h3>
    <form action="{{ route('chat_room.store') }}" method="post" class="mt-3">
        @csrf
        <div class="row">
            <div class="col-sm mt-3 mx-3">
                <div class="row">
                    <label for="roomTitle">ルーム名</label>
                    <input type="text" class="form-control" id="roomTitle" name="room_title" value="{{ old('room_title') }}">
                </div>
                @if ($errors->has("room_title"))
                    <div class="row mt-2">
                        <ul style="list-style: none">
                            @foreach ($errors->get("room_title") as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-sm m-3">
                <div class="row">
                    <label for="officeName">事業所</label>
                    <select name="office_id" id="officeName" class="custom-select">
                        <option value="">選択してください</option>
                        @foreach ($offices as $office)
                            <option value="{{ $office->id }}"
                                @if (old("office_id") == $office->id) selected @endif>
                                {{ $office->office_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @if ($errors->has("office_id"))
                    <div class="row mt-2">
                        <ul style="list-style: none">
                            @foreach ($errors->get("office_id") as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="row ml-0">
            <div class="row w-100">
                <div class="col-sm-auto mt-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#peopleListModal" data-target-group="staff">メンバー選択（職員）</button>
                </div>
                <div class="col-sm-auto mt-3 mb-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#peopleListModal" data-target-group="user">メンバー選択（利用者）</button>
                </div>
            </div>
            <!-- モーダルの中身を渡すときのキーをcheckBoxと仮定 -->
            @if ($errors->has("checkBox"))
                <div class="row mt-2">
                    <ul style="list-style: none">
                        @foreach ($errors->get("checkBox") as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <input form="main-form" name="target_users" id="target_users" class="@error('target_users') is-invalid @enderror @error('target_users.*') is-invalid @enderror" hidden>
        @error('target_users')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        @error('target_users.*')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        {{--
        <div class="row justify-content-start mx-auto my-4">
            <div class="mx-4 user-list-wrapper insert-checked-people">
                @if(old("target_users") == "")
                    <p class="text-danger">未選択</p>
                @else
                    <p>読み込み中...</p>
                @endif
            </div>
        </div>
        --}}
        <div class="row ml-0 mt-3">
            <button class="btn btn-primary" type="submit">登録</button>
        </div>
    </form>
</div>
@endsection
@include("component.people_list")