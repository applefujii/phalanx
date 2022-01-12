@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/user_page2.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div id="schedule" class="col-md-8">
                <div id="scroll" class="d-none d-md-block">
                    @include('schedule', [$notifications_groups,])
                </div>
                <div class="d-md-none">
                    @include('schedule', [$notifications_groups,])
                </div>
            </div>
            <div class="buttons-container col-md-4 space_for_footer">
                @if(Auth::user()->not_super())
                <p class="text-center d-none d-md-block">
                    <button class="chat_button btn @if ($exist_unread) btn-warning @else btn-primary @endif" onclick="location.href='{{ route('chat.index') }}'">
                        @if ($exist_unread)
                            <svg xmlns="{{  asset('image/exclamation-circle.svg')  }}" width="20" height="20" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 20 20">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                            </svg>
                        @endif
                        <span>チャット</span>
                    </button>
                </p>
                @endif
                @if (Auth::user()->is_staff())
                <p class="text-center">
                    <button class="btn btn-primary" onclick="location.href='{{ route('chat_room.index') }}'">チャットルーム管理</button>
                </p>
                <p class="text-center">
                    <button class="btn btn-primary" onclick="location.href='{{ route('notification.index') }}'">予定通知管理</button>
                </p>
                <p class="text-center">
                    <button type="button" class="btn @if ($new_trial_applications) btn-warning @else btn-primary @endif" onclick="location.href='{{ route('trial_application_manage.index', ['office_id' => Auth::user()->office_id]) }}'">
                        @if ($new_trial_applications)
                            <svg xmlns="{{  asset('image/exclamation-circle.svg')  }}" width="20" height="20" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 20 20">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                            </svg>
                        @endif
                        <span>体験・見学申込管理</span>
                    </button>
                </p>
                <p class="text-center">
                    <button class="btn btn-primary" onclick="location.href='{{ route('aptitude_question_manage.index') }}'">適性診断質問管理</button>
                </p>
                <p class="text-center">
                    <button class="btn btn-primary" onclick="location.href='{{ route('user.index') }}'">ユーザーマスタ管理</button>
                </p>
                <p class="text-center">
                    <button class="btn btn-primary" onclick="location.href='{{ route('office.index') }}'">事業所マスタ管理</button>
                </p>
                @endif
                <p class="text-center">
                    <button class="btn btn-secondary" onclick="location.href='{{ route('top') }}'">トップに戻る</button>
                </p>
                <div class="d-md-none">
                    <span class="space_for_footer"></span>
                </div>
            </div>

            <div id="footer" class="d-md-none col-md-12 pb-4 pt-2 bg-white">
                @if(Auth::user()->not_super())
                <button class="chat_button btn col-12 @if ($exist_unread) btn-warning @else btn-primary @endif" onclick="location.href='{{ route('chat.index') }}'">
                    @if ($exist_unread)
                        <svg xmlns="{{  asset('image/exclamation-circle.svg')  }}" width="20" height="20" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 20 20">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                        </svg>
                    @endif
                    チャット
                </button>
                @endif
            </div>
        </div>
    </div>

@endsection


@section('script')
    {{-- <script>
        $(() => {
            if ($('#scroll').length) {
                // スクロール可能な部分の高さ
                $("#scroll").innerHeight(
                    $(window).height() - $('nav').outerHeight() -60
                );

                // 画面サイズが変更されたら
                $(window).on('resize', () => {
                    // スクロール可能な部分の高さ
                    $("#scroll").innerHeight(
                        $(window).height() - $('nav').outerHeight() -60
                    );
                });
            }
        });
    </script> --}}
@endsection
