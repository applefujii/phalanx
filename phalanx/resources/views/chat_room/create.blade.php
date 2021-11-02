@extends('layout.app')
@section('content')
<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
<h3 class="page_title">チャットルーム管理　新規作成</h3>
<div class="container-md">
    <form action="{{ route('chat_rooms.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-sm">
                <div class="row">
                    <label for="roomTitle">ルーム名</label>
                    <input type="text" class="form-control" id="roomTitle" name="room_title" value="{{ old('room_title') }}">
                </div>
                @if ($errors->has("room_title"))
                    <div class="row">
                        <ul style="list-style: none">
                            @foreach ($errors->get("room_title") as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-sm">
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
                @if ($errors->has("room_title"))
                    <div class="row">
                        <ul style="list-style: none">
                            @foreach ($errors->get("room_title") as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-sm-auto">
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#peopleListModal" data-target-group="staff">メンバー選択（職員）</button>
            </div>
            <div class="col-sm-auto">
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#peopleListModal" data-target-group="user">メンバー選択（利用者）</button>
            </div>
        </div>
        <div class="row">
            <button class="btn btn-primary" type="submit">更新</button>
        </div>
    </form>
    @include("component.people_list")
</div>
@endsection