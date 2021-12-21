@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/user_page2.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid p-0 m-0">
        <div id="user-main" class="col-12 p-0 m-0">
            <div id="scroll" class="px-2 py-4">
                <div class="row mx-2">
                    <div class="@if (Auth::user()->is_staff()) col-md-8 @else col-md-12 p-0 m-0 @endif">
                        <h2>予定</h2>
                        <div class="notifications">
                            @if ($notifications_groups->count() === 0)
                                <span>予定はありません</span>
                            @else
                                @foreach ($notifications_groups as $key => $notifications)
                                    @if ($key !== '期限切れ')
                                        <div class="date">
                                            <span class="date-title">{{ $key }}</span>
                                            @foreach ($notifications as $notification)
                                                @php
                                                    $start_at = new Carbon\Carbon($notification->start_at);
                                                    $end_at = new Carbon\Carbon($notification->end_at);
                                                    if ($notification->date_if_allday()) {
                                                        $start_at = $start_at->isoFormat('YYYY年MM月DD日(ddd)');
                                                        $end_at = $end_at->isoFormat('YYYY年MM月DD日(ddd)');
                                                    } else {
                                                        $start_at = $start_at->isoFormat('YYYY年MM月DD日(ddd) HH:mm');
                                                        $end_at = $end_at->isoFormat('YYYY年MM月DD日(ddd) HH:mm');
                                                    }
                                                @endphp
                                                <div class="notification-card border border-secondary rounded p-2">
                                                    <span>{{ $start_at }}</span>
                                                    <br class="d-block d-md-none">
                                                    <span> ～ {{ $end_at }}</span>
                                                    <div class="p-2">
                                                        <span class="notification-content">{{ $notification->content }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                    

                    @if (Auth::user()->is_staff())
                        <div class="buttons-container col-md-4">
                            <p>
                                <button class="btn btn-primary"
                                    onclick="location.href='{{ route('chat_room.index') }}'">チャットルーム管理</button>
                            </p>
                            <p>
                                <button class="btn btn-primary"
                                    onclick="location.href='{{ route('notification.index') }}'">通知管理</button>
                            </p>
                            <p>
                                <button class="btn @if ($new_trial_applications) btn-warning @else btn-primary @endif"
                                    onclick="location.href='{{ route('trial_application_manage.index', ['office_id' => Auth::user()->office_id]) }}'">体験・見学申込管理</button>
                            </p>
                            <p>
                                <button class="btn btn-primary"
                                    onclick="location.href='{{ route('aptitude_question_manage.index') }}'">適性診断質問管理</button>
                            </p>
                            <p>
                                <button class="btn btn-primary"
                                    onclick="location.href='{{ route('user.index') }}'">ユーザーマスタ管理</button>
                            </p>
                            <p><button class="btn btn-primary"
                                    onclick="location.href='{{ route('office.index') }}'">事業所マスタ管理</button>
                            </p>
                            <p><button class="btn btn-secondary" onclick="location.href='{{ route('top') }}'">トップに戻る</button>
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <div id="footer" class="col-12">
                <button id="chat_button" class="btn btn-primary col-12 m-2"
                    onclick="location.href='{{ route('chat.index') }}'">チャット</button>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script>
        $(() => {
            $("main").removeClass("py-4");
            $("#user-main").css({top: $('nav').outerHeight()});
            // スクロール可能な部分の高さ
            $("#scroll").innerHeight(
                $(window).height() - $('nav').outerHeight() - $('#footer').outerHeight()
            );

            // 画面サイズが変更されたら
            $(window).on('resize', () => {
                // スクロール可能な部分の高さ
                $("#scroll").innerHeight(
                    $(window).height() - $('nav').outerHeight() - $('#footer').outerHeight()
                );
            });
        });
    </script>
@endsection
