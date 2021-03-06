@extends('layouts.app')

@section("title", "予定通知管理　新規登録")
@section('css')
<link href="{{ asset('css/notification/create_and_edit.css') }}" rel="stylesheet">
@endsection
@section('content')
<?php
    use Carbon\Carbon;
    $start_at_str = old('start_at');
    $end_at_str = old('end_at');
    if (is_null($start_at_str)) {
        $start_at = new Carbon($start_at_str);
    }
    if (is_null($end_at_str)) {
        $end_at = new Carbon($end_at_str);
    }
    $now_at = new Carbon('now');
?>

{{ $start_at_str }}
<div class="container">
    <h3>予定通知管理　新規登録</h3>
    <div class="form-group">
        <div class="row justify-content-start mx-auto my-4">
            <div class="mx-4">
                <label>開始日時</label><br />
                <input form="main-form" name="start_date" type="date" value="{{ old('start_date', isset($start_at) ? $start_at->isoFormat('YYYY-MM-DD') : $now_at->isoFormat('YYYY-MM-DD') )}}" class="@error('start_at') is-invalid @enderror" max="9999-12-31">
                <input id="start_time" form="main-form" name="start_time" type="time" value="{{ old('start_time', isset($start_at) ? $start_at->isoFormat('HH:mm') : $now_at->isoFormat('HH:mm') ) }}" class="@error('start_at') is-invalid @enderror">
                @error('start_at')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mx-4">
                <label>終了日時</label><br />
                <input form="main-form" name="end_date" type="date" value="{{ old('end_date', isset($end_at) ? $end_at->isoFormat('YYYY-MM-DD') : $now_at->isoFormat('YYYY-MM-DD') ) }}" class="@error('end_at') is-invalid @enderror" max="9999-12-31">
                <input id="end_time" form="main-form" name="end_time" type="time" value="{{ old('end_time', isset($end_at) ? $end_at->isoFormat('HH:mm') : $now_at->isoFormat('HH:mm') ) }}" class="@error('end_at') is-invalid @enderror">
                @error('end_at')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="row justify-content-start mx-auto my-4">
            <div class="mx-4">
                <input form="main-form" type="hidden" name="is_all_day" value="0">
                <input form="main-form" name="is_all_day" value="1" type="checkbox" id="allday" @if (old('is_all_day')) checked @endif><label for="allday" class="@error('is_all_day') is-invalid @enderror">終日</label>
                @error('is_all_day')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="row justify-content-start mx-auto my-4">
            <div class="mx-4 textarea-wrapper">
                <label>内容</label><br />
                <textarea form="main-form" name="content" class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                @error('content')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="row justify-content-start mx-auto my-4">
            <div class="mx-4">
                <div class="row">
                    <div class="col-sm-auto mt-3">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#peopleListModal" data-target-group="office">事業所選択</button>
                    </div>
                    <div class="col-sm-auto mt-3">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#peopleListModal" data-target-group="staff">メンバー選択（職員）</button>
                    </div>
                    <div class="col-sm-auto mt-3 mb-3">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#peopleListModal" data-target-group="user">メンバー選択（利用者）</button>
                    </div>
                </div>
                <input form="main-form" name="target_offices" id="target_offices" class="@error('target_offices') is-invalid @enderror @error('target_offices.*') is-invalid @enderror" hidden>
                @error('target_offices')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @error('target_offices.*')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
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
            </div>
        </div>
        <div class="row justify-content-start mx-auto my-4">
            <div class="mx-4 user-list-wrapper insert-checked-people">
                @if(old("target_users") == "")
                    <p class="text-danger">未選択</p>
                @else
                    <p>読み込み中...</p>
                @endif
            </div>
        </div>
        <form id="main-form" name="data" action="{{ route('notification.store') }}" method="POST">
            @csrf
        </form>
        <input type="submit" form="main-form" class="btn btn-primary mx-4" value="登録">
        <a href="{{ route('notification.index') }}" class="btn btn-secondary mx-4">キャンセル</a>
    </div>
</div>

@endsection


@section("script")

@include("component.people_list")

<script>
    //-- 終日にチェックに時間ダイアログをdisableにする
    $( function(){
        if($('#allday').prop('checked')) {
            $('#start_time').attr('disabled', true);
            $('#end_time').attr('disabled', true);
        }
    });
    $(document).on('click', '#allday', function(){
        if( $(this).prop('checked') == true ) {
            $('#start_time').attr('disabled', true);
            $('#end_time').attr('disabled', true);
        } else {
            $('#start_time').attr('disabled', false);
            $('#end_time').attr('disabled', false);
        }
    });

    //-- 日付入力欄からフォーカスが外れた際に「開始日時＞終了日時」だったらフォーカスされていた入力欄の日付で統一
    $(document).on('focusout', '[name=start_date]', function(){
        format = "YYYY-MM-DD";
        st = new Date( $(this).val() );
        ed = new Date( $('[name=end_date]').val() );
        if( st > ed ) {
            console.log("in");
            format = format.replace('YYYY', st.getFullYear());
            format = format.replace('MM', (st.getMonth()+1).toString(10).padStart(2, '0'));
            format = format.replace('DD', st.getDate().toString(10).padStart(2, '0'));
            $('[name=end_date]').val(format);
        }
    });

    $(document).on('focusout', '[name=end_date]', function(){
        format = "YYYY-MM-DD";
        ed = new Date( $(this).val() );
        st = new Date( $('[name=start_date]').val() );
        if( st > ed ) {
            console.log("in");
            format = format.replace('YYYY', ed.getFullYear());
            format = format.replace('MM', (ed.getMonth()+1).toString(10).padStart(2, '0'));
            format = format.replace('DD', ed.getDate().toString(10).padStart(2, '0'));
            $('[name=start_date]').val(format);
        }
    });
</script>

@endsection
