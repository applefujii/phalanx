@extends('layouts.app')
@section('css')
<link href="{{ asset('css/notification/create_and_edit.css') }}" rel="stylesheet">
@endsection
@section('content')
@php
    use Carbon\Carbon;
    $start_at_str = old('start_at', $notification->start_at);
    $end_at_str = old('end_at', $notification->end_at);
    $start_at = new Carbon($start_at_str);
    $end_at = new Carbon($end_at_str);
@endphp

<div class="container">
    <h3>予定通知　更新</h3>
    <div class="form-group">
        <div class="row justify-content-start mx-auto my-4">
            <div class="mx-4">
                <label>開始日時</label><br />
                <input form="main-form" name="start_date" type="date" value="{{ $start_at->isoFormat('YYYY-MM-DD') }}">
                <input form="main-form" name="start_time" type="time" value="{{ $start_at->isoFormat('HH:mm') }}">
            </div>
            <div class="mx-4">
                <label>終了日時</label><br />
                <input form="main-form" name="end_date" type="date" value="{{ $end_at->isoFormat('YYYY-MM-DD') }}">
                <input form="main-form" name="end_time" type="time" value="{{ $end_at->isoFormat('HH:mm') }}">
            </div>
        </div>
        <div class="row justify-content-start mx-auto my-4">
            <div class="mx-4">
                <input form="main-form" type="hidden" name="is_all_day" value="0">
                <input form="main-form" name="is_all_day" type="checkbox" value="1" id="allday" @if (old('is_all_day', $notification->is_all_day)) checked @endif><label for="allday">終日</label>
            </div>
        </div>
        <div class="row justify-content-start mx-auto my-4">
            <div class="mx-4 textarea-wrapper">
                <label>内容</label><br />
                <textarea form="main-form" name="content" class="form-control">{{ old('content', $notification->content) }}</textarea>
            </div>
        </div>
        <div class="row justify-content-start mx-auto my-4">
            <button type="button" class="mx-4 btn btn-secondary btn-sm" data-toggle="modal" data-target="#peopleListModal" data-target-group="user">
                + 対象
            </button>
            <input form="main-form" name="old_target_users" id="old_target_users" hidden>
            <input form="main-form" name="target_users" id="target_users" hidden>
        </div>
        <div class="row justify-content-start mx-auto my-4">
            <div class="mx-4 user-list-wrapper insert-checked-people">
                <p>読み込み中...</p>                      
            </div>
        </div>
        <form id="main-form" name="data" action="{{ route('notification.update', $notification->id) }}" method="POST">
            @csrf
            @method('PUT')
        </form>
        <input type="submit" form="main-form" class="btn btn-primary mx-4" value="更新">
        <a href="{{ route('notification.index') }}" class="btn btn-secondary mx-4">戻る</a>
    </div>
</div>
@endsection

@include("component.people_list")
