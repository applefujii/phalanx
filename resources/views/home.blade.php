@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center">
        <h3>予定</h3>
        <p><a class="btn btn-primary" role="button" href="{{ route('chat_room.index') }}">チャット</a></p>
        @if (Auth::user()->user_type_id === 1)
            <p><a class="btn btn-primary" role="button" href="{{ route('home') }}">チャットルーム管理</a></p>
            <p><a class="btn btn-primary" role="button" href="{{ route('trial_application_manage.index') }}">体験・見学 申込管理</a></p>
            <p><a class="btn btn-primary" role="button" href="{{ route('aptitude_question_manage.index') }}">適性診断 質問管理</a></p>
            <p><a class="btn btn-primary" role="button" href="{{ route('user.index') }}">ユーザーマスター</a></p>
            <p><a class="btn btn-primary" role="button" href="{{ route('office.index') }}">事業所マスター</a></p>
        @endif
        <p><a class="btn btn-secondary" role="button" href="{{ route('top') }}">トップに戻る</a></p>
    </div>
</div>
@endsection
