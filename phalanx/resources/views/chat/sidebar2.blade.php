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
        <div class="side-scroll container-fluid pb-2">
            @include('chat.sidebar_left', [$join_chat_rooms, $offices, "size" => "small"])
        </div>
    </nav>
</div>

{{-- 右ナビゲーション --}}
<div id="nav-right-container" class="d-block d-md-none" style='visibility: hidden'>
    <div id="nav-button-right" class="nav-button openbtn d-flex align-items-center justify-content-start" data-is-open="false"><i class="fas fa-chevron-left"></i></div>
    <nav id="nav-right" class="edge-nav">
        <div class="side-scroll container-fluid">
            @if (isset($chat_room))
                @include('chat.sidebar_right', [$user_types, $offices, $chat_room, "size" => "small"])
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
            <div class="side-scroll container-fluid pb-2">
                @include('chat.sidebar_left', [$join_chat_rooms, $offices, "size" => "large"])
            </div>
        </div>
        <div class="col-md-8 bg-white border-top p-0">
            @yield('center')
        </div>
        <div class="col-md-2 d-none d-md-block border border-dark pr-0">
            <div class="side-scroll">
                @if (isset($chat_room))
                    @include('chat.sidebar_right', [$user_types, $offices, $chat_room, "size" => "large"])
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

@yield("c_script")

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
        });

        //#open_subが押された時の動作
        $(".open_sub").click(function() {
            let fas = $(this).find(".fas");
            fas.toggleClass("fa-chevron-down");
            fas.toggleClass("fa-chevron-up");
        });

        //未読テキストがあるチャットルームのリンクの色を変更し、折りたたまれているなら展開する
        let collapse;
        let id;
        $.map(@json($unreadId), (val, index) => {
            $(`.chat_room_${val}`).addClass("text-success");
            $(`.chat_room_${val}`).children('span').removeClass('d-none');
            collapse = $(`.chat_room_${val}`).parents(".collapse");
            if(!collapse.hasClass("show")) {
                id = collapse.attr("id");
                $(`button[data-target="#${id}"]`).trigger("click");
            }
        });

        @if ($subUnread)
            $(".open_sub").removeClass("btn-outline-dark").addClass("btn-outline-success");
        @endif
        
    });

</script>

@endsection