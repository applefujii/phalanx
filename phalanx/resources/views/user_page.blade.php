@extends('layouts.app')
@section('css')
<link href="{{ asset('css/user_page.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container">
  <div class="pagelayout">
    <div class="buttons-container">
      <div class="buttons-first-column">
        <button class="btn btn-primary chat-link-button" onclick="location.href='{{ route("chat.index") }}'">チャット</button>
        <button class="btn btn-primary" onclick="location.href='{{ route("chat_room.index") }}'">チャットルーム管理</button>
        <button class="btn btn-primary" onclick="location.href='{{ route("notification.index") }}'">通知管理</button>
        <button class="btn @if ($new_trial_applications) btn-warning @else btn-primary @endif" onclick="location.href='{{ route("trial_application_manage.index", ["office_id" => Auth::user()->office_id]) }}'">体験・見学申込一覧</button>
        <button class="btn btn-primary" onclick="location.href='{{ route("aptitude_question_manage.index") }}'">適性診断質問管理</button>
      </div>
      <div class="buttons-second-column">
        <button class="btn btn-primary" onclick="location.href='{{ route("user.index") }}'">ユーザーマスタ管理</button>
        <button class="btn btn-primary" onclick="location.href='{{ route("office.index") }}'">事業所マスタ管理</button>
      </div>
    </div>
    <div class="notification">
      <div class="sidebar">
        <div class="sidebar-position-base">
          <h2>予定</h2>
          <div class="sidebar-container">
            <div>
              <div class="notification-date-header sticky-top">今週</div>
              <div class="notification-content">{{ "2020/03/16 12:45～\n2020/03/16 14:30\n\nアップル梅田体験" }}</div>
            </div>
            <div>
              <div class="notification-date-header sticky-top">来週以降</div>
              <div class="notification-content">{{ "2020/08/05\n\n休日開所" }}</div>
              <div class="notification-content">{{ "2020/08/06 ～\n2020/08/08\n\nアップル梅田体験" }}</div>
              <div class="notification-content">{{ "2020/08/06 ～\n2020/08/08\n\nアップル梅田体験" }}</div>
              <div class="notification-content">{{ "2020/08/06 ～\n2020/08/08\n\nアップル梅田体験" }}</div>
              <div class="notification-content">{{ "2020/08/06 ～\n2020/08/08\n\nアップル梅田体験" }}</div>
              <div class="notification-content">{{ "2020/08/06 ～\n2020/08/08\n\nアップル梅田体験" }}</div>
              <div class="notification-content">{{ "2020/08/06 ～\n2020/08/08\n\nアップル梅田体験" }}</div>
              <div class="notification-content">{{ "2020/08/06 ～\n2020/08/08\n\nアップル梅田体験" }}</div>
              <div class="notification-content">{{ "2020/08/06 ～\n2020/08/08\n\nアップル梅田体験" }}</div>
              <div class="notification-content">{{ "2020/08/06 ～\n2020/08/08\n\nアップル梅田体験" }}</div>
              <div class="notification-content">{{ "2020/08/06 ～\n2020/08/08\n\nアップル梅田体験" }}</div>
              <div class="notification-content">{{ "2020/08/06 ～\n2020/08/08\n\nアップル梅田体験" }}</div>
            </div>
          </div>
          <div class="sidebar-top"></div>
          <div class="sidebar-bottom"></div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection