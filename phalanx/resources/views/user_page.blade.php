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
        @if (Auth::user()->is_staff())
          <button class="btn btn-primary" onclick="location.href='{{ route("chat_room.index") }}'">チャットルーム管理</button>
          <button class="btn btn-primary" onclick="location.href='{{ route("notification.index") }}'">通知管理</button>
          <button class="btn @if ($new_trial_applications) btn-warning @else btn-primary @endif" onclick="location.href='{{ route("trial_application_manage.index", ["office_id" => Auth::user()->office_id]) }}'">
            体験・見学申込管理
            @if ($new_trial_applications)
              <br>
              <span class="text-danger font-weight-bold">新しい申込があります</span>
            @endif
          </button>
          <button class="btn btn-primary" onclick="location.href='{{ route("aptitude_question_manage.index") }}'">適性診断質問管理</button>
        @else
          <button class="btn btn-secondary" onclick="location.href='{{ route('top') }}'">トップに戻る</button>
        @endif
      </div>
      @if (Auth::user()->is_staff())
        <div class="buttons-second-column">
          <button class="btn btn-primary" onclick="location.href='{{ route("user.index") }}'">ユーザーマスタ管理</button>
          <button class="btn btn-primary" onclick="location.href='{{ route("office.index") }}'">事業所マスタ管理</button>
          <button class="btn btn-secondary" onclick="location.href='{{ route('top') }}'">トップに戻る</button>
        </div>
      @endif
    </div>
    <div class="notification">
      <div class="sidebar">
        <div class="sidebar-position-base">
          <h2>予定</h2>
          @if ($notifications_groups->count() === 0)
            <div class="non-notifications">予定なし</div>
          @else
            <div class="sidebar-container">
              @foreach ($notifications_groups as $key => $notifications)
                <div>
                  <div class="notification-date-header sticky-top">{{ $key }}</div>
                  @foreach ($notifications as $notification)
                    <div class="notification-card">
                      @if ($notification->is_all_day)
                      <span class="notification-start-at">{{ $notification->date_if_allday() }}</span>
                      <br>
                      @else
                        <div class="notification-start-at">{{ $notification->start_at }}</div>
                        <div class="notification-end-at">～ {{ $notification->end_at }}</div>
                      @endif
                      <div class="notification-content">{{ $notification->content }}</div>
                    </div>
                  @endforeach
                </div>
              @endforeach
            </div>
            <div class="sidebar-top"></div>
            <div class="sidebar-bottom"></div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

@endsection