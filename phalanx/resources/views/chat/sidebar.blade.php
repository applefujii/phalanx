@extends('layouts.app')

@section('css')
<link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
@yield("c_css")
@endsection

@section("content")
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 d-none d-md-block border border-dark px-0">
            <div class="scroll-contents container-fluid">
                @include('chat.sidebar_left', [$join_chat_rooms, $offices])
            </div>
        </div>
        <div class="col-md-8 bg-white border-top p-0">
            <button type="button" class="btn btn-dark rounded-circle position-fixed mt-5 d-block d-md-none sidebar-open" id="left-open" data-toggle="modal" data-target="#left-modal">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="modal fade" id="left-modal" tabindex="-1">
                <div class="modal-dialog d-md-none">
                    <div class="modal-content h-100">
                        <div class="modal-body">
                            @include('chat.sidebar_left', [$join_chat_rooms, $offices])
                        </div>
                    </div>
                </div>
            </div>
            @if (isset($chat_room))
                <button type="button" class="btn btn-dark rounded-circle position-fixed mt-5 d-block d-md-none sidebar-open" id="right-open" data-toggle="modal" data-target="#right-modal">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="modal fade" id="right-modal" tabindex="-1">
                    <div class="modal-dialog d-md-none">
                        <div class="modal-content h-100">
                            <div class="modal-body">
                                @if (isset($chat_room))
                                    @include('chat.sidebar_right', [$user_types, $offices, $chat_room])
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @yield('center')

        </div>
        <div class="col-md-2 d-none d-md-block border border-dark pr-0">
            <div class="scroll-contents">
                @if (isset($chat_room))
                    @include('chat.sidebar_right', [$user_types, $offices, $chat_room])
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(function() {

            //ナビゲーションバーの高さを取得
            let navHeight = $("nav").innerHeight();

            //.scroll-contentsの高さを調整
            $(".scroll-contents").css("height", `calc(100vh - 2px - ${navHeight}px)`);
            $("main").css("height", `calc(100vh - 2px - ${navHeight}px)`);
            
            $(".navbar-toggler").click(function() {
                setTimeout(function() {
                    navHeight = $("nav").innerHeight();
                    $(".scroll-contents").css("height", `calc(100vh - 2px - ${navHeight}px)`);
                    $("main").css("height", `calc(100vh - 2px - ${navHeight}px)`);
                }, 500);
            });

            $("#navbarDropdown").click(function() {
                setTimeout(function() {
                    navHeight = $("nav").innerHeight();
                    $(".scroll-contents").css("height", `calc(100vh - 2px - ${navHeight}px)`);
                    $("main").css("height", `calc(100vh - 2px - ${navHeight}px)`);
                }, 100);
            })

            //#sub-officesが押された時の動作
            $(".sub-offices").click(function(){
                let fas = $(this).find(".fas");
                if( fas.hasClass("fa-chevron-down") ) {
                    fas.removeClass("fa-chevron-down");
                    fas.addClass("fa-chevron-up");
                } else {
                    fas.removeClass("fa-chevron-up");
                    fas.addClass("fa-chevron-down");
                }
            });

            //未読テキストがあるチャットルームのリンクの色を変更
            $.map(@json($unreadId), (val, index) => {
                $(`.chat_room_${val}`).addClass("text-danger");
                $(`.chat_room_${val}`).children('span').removeClass('d-none');
            });
        });
    </script>

@yield("c_script")

@endsection