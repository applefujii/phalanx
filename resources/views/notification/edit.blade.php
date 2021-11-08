@extends('layouts.app')
@section('css')
<link href="{{ asset('css/notification/create_and_edit.css') }}" rel="stylesheet">
@endsection
@section('content')
<?php
    use Carbon\Carbon;
    $start_at_str = old('start_at', $notification->start_at);
    $end_at_str = old('end_at', $notification->end_at);
    $start_at = new Carbon($start_at_str);
    $end_at = new Carbon($end_at_str)
?>
<div class="container">
    <h3>予定通知　更新</h3>
    <form>
        <div class="form-group">
            <div class="row justify-content-start mx-auto my-4">
                <div class="mx-4">
                    <label>開始日時</label><br />
                    <input type="date" value="{{ $start_at->isoFormat('YYYY-MM-DD') }}">
                    <input type="time" value="{{ $start_at->isoFormat('HH:mm') }}">
                </div>
                <div class="mx-4">
                    <label>終了日時</label><br />
                    <input type="date" value="{{ $end_at->isoFormat('YYYY-MM-DD') }}">
                    <input type="time" value="{{ $end_at->isoFormat('HH:mm') }}">
                </div>
            </div>
            <div class="row justify-content-start mx-auto my-4">
                <div class="mx-4">
                    <input type="checkbox" id="allday" @if (old('is_all_day', $notification->is_all_day)) checked @endif><label for="allday">終日</label>
                </div>
            </div>
            <div class="row justify-content-start mx-auto my-4">
                <div class="mx-4 textarea-wrapper">
                    <label>内容</label><br />
                    <textarea class="form-control">{{ old('content', $notification->content) }}</textarea>
                </div>
            </div>
            <div class="row justify-content-start mx-auto my-4">
                <a href="#" class="mx-4 btn btn-secondary btn-sm"> + 対象</a>
            </div>
            <div class="row justify-content-start mx-auto my-4">
                <div class="mx-4 user-list-wrapper">
                    <span>ああああ, いいいいい, うううう, ええええええ, おおおおおお, かかかかかかかか, ききききききき,くくくくく   …他9名
                    </span>                        
                </div>
            </div>
            <input type="submit" class="btn btn-primary mx-4" value="更新">
            <a href="{{ route('notification.index') }}" class="btn btn-secondary mx-4">戻る</a>
        </div>
    </form>
</div>
@endsection