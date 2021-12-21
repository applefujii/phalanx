@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/user_page2.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div id="schedule" class="@if (Auth::user()->is_staff()) col-md-8 @else col-md-12 p-0 m-0 @endif">
                <div id="scroll" class="d-none d-md-block">
                    @include('schedule', [$notifications_groups,])
                </div>
                <div class="d-md-none">
                    @include('schedule', [$notifications_groups,])
                </div>
            </div>
            
            @if (Auth::user()->is_staff())
            <div class="buttons-container col-md-4 space_for_footer">
                <p class="text-center">
                    <button class="btn btn-primary"
                        onclick="location.href='{{ route('chat_room.index') }}'">チャットルーム管理</button>
                </p>
                <p class="text-center">
                    <button class="btn btn-primary"
                        onclick="location.href='{{ route('notification.index') }}'">通知管理</button>
                </p>
                <p class="text-center">
                    <button class="btn @if ($new_trial_applications) btn-warning @else btn-primary @endif"
                        onclick="location.href='{{ route('trial_application_manage.index', ['office_id' => Auth::user()->office_id]) }}'">
                        体験・見学申込管理
                        @if ($new_trial_applications)
                            <br>
                            <span class="text-danger font-weight-bold">新しい申込があります</span>
                        @endif
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
                <p class="text-center">
                    <button class="btn btn-secondary" onclick="location.href='{{ route('top') }}'">トップに戻る</button>
                </p>
                <div class="d-md-none">
                    <span class="space_for_footer"></span>
                </div>
            </div>
            @endif

            <div id="footer" class="col-md-12 pb-4 pt-2 bg-white">
                <button id="chat_button" class="btn btn-primary col-12" onclick="location.href='{{ route('chat.index') }}'">チャット</button>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script>
        $(() => {
            if ($('#scroll').length) {
                // スクロール可能な部分の高さ
                $("#scroll").innerHeight(
                    $(window).height() - $('nav').outerHeight() - $('#footer').outerHeight() -40
                );

                // 画面サイズが変更されたら
                $(window).on('resize', () => {
                    // スクロール可能な部分の高さ
                    $("#scroll").innerHeight(
                        $(window).height() - $('nav').outerHeight() - $('#footer').outerHeight() -40
                    );
                });
            }
        });
    </script>
@endsection
