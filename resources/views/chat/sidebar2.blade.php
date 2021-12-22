@extends('layouts.app')

@section('css')
<link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
<link href="{{ asset('css/navigation.css') }}" rel="stylesheet">
@yield("c_css")
@endsection

@section("content")

{{-- 左ナビゲーション --}}
<div id="nav-left-container" class="d-block d-md-none" style='visibility: hidden'>
    <div id="nav-button-left" class="nav-button openbtn d-flex align-items-center justify-content-end" data-is-open="false"><i class="fas fa-chevron-right"></i></div>
    <nav id="nav-left" class="edge-nav">
        <div class="scroll-contents container-fluid">
            @include('chat.sidebar_left', [$join_chat_rooms, $offices])
        </div>
    </nav>
</div>

{{-- 右ナビゲーション --}}
<div id="nav-right-container" class="d-block d-md-none" style='visibility: hidden'>
    <div id="nav-button-right" class="nav-button openbtn d-flex align-items-center justify-content-start" data-is-open="false"><i class="fas fa-chevron-left"></i></div>
    <nav id="nav-right" class="edge-nav">
        <div class="scroll-contents container-fluid">
            @if (isset($chat_room))
                @include('chat.sidebar_right', [$user_types, $offices, $chat_room])
            @endif
        </div>
    </nav>
</div>

{{-- ナビゲーション表示時の背景オーバーレイ --}}
<div id="cover" class="nav-background" hidden>
</div>



<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 d-none d-md-block border border-dark px-0">
            <div class="scroll-contents container-fluid">
                @include('chat.sidebar_left', [$join_chat_rooms, $offices])
            </div>
        </div>
        <div class="col-md-8 bg-white border-top p-0">
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
{{-- クラス読み込み --}}
<script src="{{ asset('js/cover.js') }}"></script>
<script src="{{ asset('js/touchInfo.js') }}"></script>
<script src="{{ asset('js/edgeNavigation.js') }}"></script>

<script>

    var fRightNav = {{ isset($chat_room) ? 'true' : 'false' }};

    $(function() {

        //------------ ナビゲーションバーの動作 ------------------------------------------

        // インスタンス作成
        var touch = new touchInfo(5);
        var navManager = new navigationManager();
        touch.addStartCallBack(navManager.touchStart, navManager);
        touch.addMoveCallBack(navManager.touchMove, navManager);
        touch.addEndCallBack(navManager.touchEnd, navManager);
        navManager.add( 'left', 4, 32, 16 );
        if(fRightNav) navManager.add( 'right', 2, 32, 16 );

        // ※アニメーション確認用
        // const observer = new MutationObserver((mutationsList, observer) => {
        //     mutationsList.forEach(({target, oldValue}) => {
        //         console.log(target.style.transition);
        //         console.log('old: '+oldValue);
        //     });
        // });
        // observer.observe(document.querySelector('#cover'), { attributes: true, childList: true, subtree: true });


        //------------ その他の動作 ------------------------------------------

        //ナビゲーションバーの高さを取得
        let navHeight = $("nav").innerHeight();

        //.scroll-contentsの高さを調整
        $(".scroll-contents").css("height", `calc(100vh - 2px - ${navHeight}px)`);
        $("main").css("height", `calc(100vh - 2px - ${navHeight}px)`);


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