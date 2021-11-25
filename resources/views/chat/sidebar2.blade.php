<?php
//$chat_roomが渡されているとき参加者の情報を取得
if(isset($chat_room)) {
    $chatRoomUsers = $chat_room->chat_room__user->whereNull("deleted_at");
    if(isset($chatRoomUsers)) {
        $officers = [];
        $users = [];
        $trials = [];
        foreach($chatRoomUsers as $chatRoomUser) {

            //職員のデータをoffice_idをキーにして$officersに入れる
            if($chatRoomUser->user->user_type_id == 1) {

                //$officersにすでにoffice_idと同じキーの配列があればその配列の後ろに入れ、なければ作る
                if(isset($officers[$chatRoomUser->user->office_id])) {
                    arary_push($officers[$chatRoomUser->user->office_id], $chatRoomUser->user->name);
                } else {
                    $officers[$chatRoomUser->user->office_id] = [$chatRoomUser->user->name];
                }
            } 
            
            //利用者も同様に処理する
            else if($chatRoomUser->user->user_type_id == 2) {
                if(isset($users[$chatRoomUser->user->office_id])) {
                    arary_push($users[$chatRoomUser->user->office_id], $chatRoomUser->user->name);
                } else {
                    $users[$chatRoomUser->user->office_id] = [$chatRoomUser->user->name];
                }
            }

            //体験者を$trialsに入れる
            else {
                $trials[] = $chatRoomUser->user->name;
            }
        }
    }
}
?>


@extends('layouts.app')

@section('css')
<link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
<link href="{{ asset('css/navigation.css') }}" rel="stylesheet">
@yield("c_css")
@endsection

@section("content")

<div id="nav-left-container" style="display: none">
    <div id="nav-button-left" class="nav-button openbtn d-flex align-items-center justify-content-end" data-is-open="false"><i class="fas fa-chevron-right"></i></div>
    <nav id="nav-left" class="edge-nav">
        <div id="nav-list-left" class="nav-list">
            <ul>
                <li><a href="#">Top</a></li> 
                <li><a href="#">About</a></li> 
                <li><a href="#">Service</a></li> 
                <li><a href="#">Contact</a></li> 
            </ul>
        </div>
    </nav>
</div>

<div id="nav-right-container" style="display: none">
    <div id="nav-button-right" class="nav-button openbtn d-flex align-items-center justify-content-start" data-is-open="false"><i class="fas fa-chevron-left"></i></div>
    <nav id="nav-right" class="edge-nav">
        <div id="nav-list-right" class="nav-list">
            <ul>
                <li><a href="#">Top</a></li> 
                <li><a href="#">About</a></li> 
                <li><a href="#">Service</a></li> 
                <li><a href="#">Contact</a></li> 
            </ul>
        </div>
    </nav>
</div>

<div id="cover" style="position: fixed; top: 0; left: 0; width: 100%; height:100%; z-index: 990; background-color: #00000055" hidden>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 d-none d-md-block border border-dark px-0">
            <div class="contents-sticky container-fluid">
                @if (Auth::user()->user_type_id == 1)
                    <div class="row p-3">
                        <a href="{{ route('chat_room.index') }}" class="btn btn-primary btn-lg btn-block" role="button">通所者一覧</a>
                    </div>
                @endif
                <div class="row">
                    @if (isset($group))
                        <div class="col-12 pt-3">
                            <h5>リテラル</h5>
                            <ul class="col-12 pt-1">
                                <li><a href="{{ route("chat.index", $group->id) }}">全職員</a></li>
                            </ul>
                        </div>
                    @endif
                    @foreach ($offices as $office)
                        @if ($office->id == Auth::user()->office_id)
                            <div class="col-12 pt-3">
                                <h5>{{ $office->office_name }}</h5>
                                <ul class="col-12 pt-1">
                                    @foreach ($joinRooms as $joinRoom)
                                        @if ($joinRoom->office_id == $office->id)
                                            <li>
                                                @if ($joinRoom->distinction_number == 4)
                                                    <a href="{{ route('chat.index', $joinRoom->id) }}">{{ $joinRoom->room_title }}</a>
                                                @else
                                                    <a href="{{ route('chat.index', $joinRoom->id) }}">{{ $office->name }}職員</a>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endforeach
                    <div class="col-12 px-0">
                        <div>
                            <button type="button" class="btn btn-outline-dark btn-block" id="sub-offices" data-toggle="collapse" data-target="#subOffices" aria-expanded="false" aria-controls="subOffices">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <div class="collapse" id="subOffices">
                            @foreach ($offices as $office)
                                @if ($office->id != Auth::user()->office_id)
                                    <div class="col-12 pt-3">
                                        <h5>{{ $office->office_name }}</h5>
                                        <ul class="col-12 pt-1">
                                            @foreach ($joinRooms as $joinRoom)
                                                @if ($joinRoom->office_id == $office->id)
                                                    <li>
                                                        @if ($joinRoom->distinction_number == 4)
                                                            <a href="{{ route('chat.index', $joinRoom->id) }}">{{ $joinRoom->room_title }}</a>
                                                        @else
                                                            <a href="{{ route('chat.index', $joinRoom->id) }}">{{ $office->name }}職員</a>
                                                        @endif
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 bg-white border-top border-dark">
            <button type="button" class="btn btn-dark rounded-circle position-fixed mt-5 d-block d-md-none sidebar-open" id="left-open" data-toggle="modal" data-target="#left-modal">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="modal fade" id="left-modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content h-100">
                        <div class="modal-body">
                            @if (Auth::user()->user_type_id == 1)
                                <div class="row p-3">
                                    <a href="{{ route('chat_room.index') }}" class="btn btn-primary btn-lg btn-block" role="button">通所者一覧</a>
                                </div>
                            @endif
                            <div class="row">
                                @if (isset($group))
                                    <div class="col-12 pt-3">
                                        <h5>リテラル</h5>
                                        <ul class="col-12 pt-1">
                                            <li><a href="{{ route("chat.index", $group->id) }}">全職員</a></li>
                                        </ul>
                                    </div>
                                @endif
                                @foreach ($offices as $office)
                                    @if ($office->id == Auth::user()->office_id)
                                        <div class="col-12 pt-3">
                                            <h5>{{ $office->office_name }}</h5>
                                            <ul class="col-12 pt-1">
                                                @foreach ($joinRooms as $joinRoom)
                                                    @if ($joinRoom->office_id == $office->id)
                                                        <li>
                                                            @if ($joinRoom->distinction_number == 4)
                                                                <a href="{{ route('chat.index', $joinRoom->id) }}">{{ $joinRoom->room_title }}</a>
                                                            @else
                                                                <a href="{{ route('chat.index', $joinRoom->id) }}">{{ $office->name }}職員</a>
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="col-12 px-0">
                                    <div>
                                        <button type="button" class="btn btn-outline-dark btn-block" id="sub-offices" data-toggle="collapse" data-target="#subOffices" aria-expanded="false" aria-controls="subOffices">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </div>
                                    <div class="collapse" id="subOffices">
                                        @foreach ($offices as $office)
                                            @if ($office->id != Auth::user()->office_id)
                                                <div class="col-12 pt-3">
                                                    <h5>{{ $office->office_name }}</h5>
                                                    <ul class="col-12 pt-1">
                                                        @foreach ($joinRooms as $joinRoom)
                                                            @if ($joinRoom->office_id == $office->id)
                                                                <li>
                                                                    @if ($joinRoom->distinction_number == 4)
                                                                        <a href="{{ route('chat.index', $joinRoom->id) }}">{{ $joinRoom->room_title }}</a>
                                                                    @else
                                                                        <a href="{{ route('chat.index', $joinRoom->id) }}">{{ $office->name }}職員</a>
                                                                    @endif
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (isset($chat_room))
                <button type="button" class="btn btn-dark rounded-circle position-fixed mt-5 d-block d-md-none sidebar-open" id="right-open" data-toggle="modal" data-target="#right-modal">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="modal fade" id="right-modal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content h-100">
                            <div class="modal-body">
                                <div class="row">
                                    <h5 class="col-12 pt-3">参加者 - {{ $chatRoomUsers->count() }}人</h5>
                                </div>
                                <div class="row">
                                    @foreach ($offices as $office)
                                        @if (isset($officers[$office->id]))
                                            <div>
                                                <h5 class="col-12 pt-3">{{ $office->office_name }}職員 - {{ count($officers[$office->id]) }}人</h5>
                                                <ul class="col-12 pt-1">
                                                    @foreach ($officers[$office->id] as $officer)
                                                        {{ $officer }}
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row">
                                    @foreach ($offices as $office)
                                        @if (isset($users[$office->id]))
                                            <div>
                                                <h5 class="col-12 pt-3">{{ $office->office_name }}通所者 - {{ count($users[$office->id]) }}人</h5>
                                                <ul class="col-12 pt-1">
                                                    @foreach ($users[$office->id] as $user)
                                                        {{ $user }}
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row">
                                    @if (isset($trials))
                                        <h5 class="col-12 pt-3">体験者 - {{ count($trials) }}人</h5>
                                        <ul class="col-12 pt-1">
                                            @foreach ($trials as $trial)
                                                <li>{{ $trial }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="contents-sticky">
                @yield('center')
            </div>
        </div>
        <div class="col-md-2 d-none d-md-block border border-dark pr-0">
            <div class="contents-sticky">
                @if (isset($chat_room))
                    <div class="row">
                        <h5 class="col-12 pt-3">参加者 - {{ $chatRoomUsers->count() }}人</h5>
                    </div>
                    <div class="row">
                        @foreach ($offices as $office)
                            @if (isset($officers[$office->id]))
                                <div>
                                    <h5 class="col-12 pt-3">{{ $office->office_name }}職員 - {{ count($officers[$office->id]) }}人</h5>
                                    <ul class="col-12 pt-1">
                                        @foreach ($officers[$office->id] as $officer)
                                            {{ $officer }}
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="row">
                        @foreach ($offices as $office)
                            @if (isset($users[$office->id]))
                                <div>
                                    <h5 class="col-12 pt-3">{{ $office->office_name }}通所者 - {{ count($users[$office->id]) }}人</h5>
                                    <ul class="col-12 pt-1">
                                        @foreach ($users[$office->id] as $user)
                                            {{ $user }}
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="row">
                        @if (isset($trials))
                            <h5 class="col-12 pt-3">体験者 - {{ count($trials) }}人</h5>
                            <ul class="col-12 pt-1">
                                @foreach ($trials as $trial)
                                    <li>{{ $trial }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
{{-- jQuery読み込み --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>

    ////////////////////// クラス /////////////////////////////////////////

    class cover {
        static fVisible = false;
        static colorA = 0;      // 0～255
        static colorR = 0;
        static colorG = 0;
        static colorB = 0;

        static off() {
            cover.fVisible = false;
            cover.colorA = 0;
            $('#cover').prop('hidden', true);
            $('#cover').css('background-color', 'rgba('+cover.colorR+','+cover.colorG+','+cover.colorB+','+cover.colorA+')');
        }
        static on( r, g, b, a ) {
            cover.fVisible = true;
            cover.colorR = r;
            cover.colorG = g;
            cover.colorB = b;
            cover.colorA = Math.round(a/255*100)/100;
            $('#cover').prop('hidden', false);
            $('#cover').css('background-color', 'rgba('+cover.colorR+','+cover.colorG+','+cover.colorB+','+cover.colorA+')');
        }
    }

    class navigation {
        /* コンストラクタ */
        constructor(manager, tagName, direction, toutchSize, navSizeRem, vW, vH) {
            this.manager = manager;
            this.navButton= '#nav-button-'+tagName, this.nav= '#nav-'+tagName;
            this.container = '#nav-'+tagName+'-container';
            this.direction= direction;
            this.toutchSize= toutchSize;
            this.navSizeRem = navSizeRem;
            this.navSizePixel = convertRemToPx(navSizeRem);
            if(direction==1) this.max= this.navSizePixel;
            else if(direction==2) this.max= vW-this.navSizePixel;
            else if(direction==3) this.max= vH-this.navSizePixel;
            else if(direction==4) this.max= this.max= this.navSizePixel;
            this.pastPosX = [], this.pastPosY = [];
            this.fOpen= false, this.fInMotion= false;
            this.fAction = false;
            this.changeViewport( vW, vH )
            this.eventRegister();
        }

        // イベント登録
        eventRegister() {
            let cl = this;
            $(document).on('click', this.navButton, function(){
                console.log('click navButton');
                if( $(cl.navButton).data('is-open') == 'true' ) cl.setOpen(false, true);
                else cl.setOpen(true, true);
            });
            $(document).on('click', this.nav+' a', function() {
                console.log('clicl a');
                cl.setOpen(false, true);
            });

            setInterval(function() {
                // console.log(cl.manager.fAnyoneOpen);
            },2000);
        }

        // タッチした時
        toutchStart( event, posX, posY ) {
            this.pastPosX = [], this.pastPosY = [];
            this.pastPosX.push(posX);
            this.pastPosY.push(posY);

            this.setTransition('all 0s');

            //-- 開いていない状態で画面端タッチなら動作させる。開いた状態で他部分をタッチしたら動作させる。
            switch(this.direction) {
                case 1:
                    break
                case 2:
                    if( !navigation.fAnyoneOpen  &&  !this.fOpen  &&  posX >= (navigation.viewportWidth-this.toutchSize)) {
                        this.fInMotion = true;
                    }
                    else if( this.fOpen ) {
                        if( !$(event.target).closest(this.navButton).length  &&  !$(event.target).closest(this.nav).length ) {
                            this.fInMotion = true;
                            console.log('toutch on');
                            this.setOpen(false);

                            let x = navigation.viewportWidth-posX;
                            if( x > this.navSizePixel ) {
                                x = this.navSizePixel;
                            }
                            this.setTransform( x );
                        }
                    }
                    break
                case 3:
                    break
                case 4:
                    if( !navigation.fAnyoneOpen  &&  !this.fOpen  &&  posX <= this.toutchSize) {
                        this.fInMotion = true;
                    }
                    else if( this.fOpen ) {
                        if( !$(event.target).closest(this.navButton).length  &&  !$(event.target).closest(this.nav).length ) {
                            this.fInMotion = true;
                            console.log('toutch on');
                            this.setOpen(false);

                            let x = posX;
                            if( x > this.navSizePixel ) {
                                x = this.navSizePixel;
                                this.fOpen = true;
                            }
                            this.setTransform( x );
                        }
                    }
                    break
            }
        }

        // スワイプ
        toutchMove( posX, posY ) {
            if( this.pastPosX.length >=5 ) this.pastPosX.shift();
            if( this.pastPosY.length >=5 ) this.pastPosY.shift();
            this.pastPosX.push(posX);
            this.pastPosY.push(posY);

            this.setTransition('all 0s');

            switch(this.direction) {
                case 1:
                    break
                case 2:
                    if(this.fInMotion) {
                        let x = navigation.viewportWidth-posX;
                        if( x > this.navSizePixel ) {
                            x = this.navSizePixel;
                            this.fOpen = true;
                        } else {
                            if( x < 0 ) x = 0;
                            this.fOpen = false;
                        }
                        this.setTransform( x );
                    }
                    break
                case 3:
                    break
                case 4:
                    if(this.fInMotion) {
                        let x = posX;
                        if( x > this.navSizePixel ) {
                            x = this.navSizePixel;
                            this.fOpen = true;
                        } else {
                            if( x < 0 ) x = 0;
                            this.fOpen = false;
                        }
                        this.setTransform( x );
                    }
                    break
            }
        }

        // タッチを離したとき
        toutchEnd( posX, posY ) {
            if(this.fInMotion) {
                //-- 速度が一定以上ならfOpenをtrueにする
                let speedX = (this.pastPosX[this.pastPosX.length-1] - this.pastPosX[0]) /this.pastPosX.length;
                let speedY = (this.pastPosY[this.pastPosY.length-1] - this.pastPosY[0]) /this.pastPosX.length;
                switch(this.direction) {
                    case 1:
                        break
                    case 2:
                        if(this.pastPosX.length>=2) {
                            if(speedX <= -2.0) this.fOpen = true;
                        } else {
                            if(this.fOpen == true) this.fOpen = false;
                        }
                        break
                    case 3:
                        break
                    case 4:
                        if(this.pastPosX.length>=2) {
                            if(speedX >= 2.0) this.fOpen = true;
                        } else {
                            if(this.fOpen == true) this.fOpen = false;
                        }
                        break
                }

                if( this.fOpen ) {
                    this.setOpen(true, true);
                } else {
                    this.setOpen(false, true);
                }
                this.setTransform( 0 );
            }

            this.fInMotion = false;
        }

        changeViewport( wid, hei ) {
            let bsSize = wid<576 ? 1 : wid<768 ? 2 : wid<992 ? 3 : wid<1200 ? 4 : wid<1400 ? 5 : 6;
            if(this.direction==1) this.max= this.navSizePixel;
            else if(this.direction==2) this.max= wid-this.navSizePixel;
            else if(this.direction==3) this.max= hei-this.navSizePixel;
            else if(this.direction==4) this.max= this.navSizePixel;
            if(bsSize<=2) {
                this.setHide(false);
            }
            else {
                this.setHide(true);
            }
        }


        //--------------- set系 ----------------------------

        toggleOpen() {
            this.setOpen( !$(this.navButton).hasClass('active'), true );
        }

        setOpen( iActive, iAnimation=false ) {
            console.log('dir:'+this.direction+'/ active:'+iActive+'/ anim:'+iAnimation);
            if(iActive) {
                if(navigation.fAnyoneOpen) return;
                if(iAnimation) this.setTransition('all .6s');
                else this.setTransition('all 0s');
                $(this.navButton).addClass('active');
                $(this.nav).addClass('panelactive');
                cover.on(0,0,0,88);
                this.fOpen = true;
                navigation.fAnyoneOpen = true;
                $(this.navButton).data('is-open', 'true');
            } else {
                if(!this.fOpen) return;
                if(iAnimation) this.setTransition('all .6s');
                else this.setTransition('all 0s');
                $(this.navButton).removeClass('active');
                $(this.nav).removeClass('panelactive');
                cover.on(0,0,0,0);
                setTimeout(function() {
                    cover.off();
                    navigation.fAnyoneOpen = false;
                }, 600);
                this.fOpen = false;
                $(this.navButton).data('is-open', 'false');
            }
        }

        setTransition(value) {
            $(this.navButton).css( 'transition', value );
            $(this.nav).css( 'transition', value );
            $('#cover').css( 'transition', value );
        }

        setTransform( volume ) {
            let a = volume/2;
            if(a > 88) a = 88;
            if(this.fOpen) cover.on(0,0,0,88)
            else {
                if(volume > 0) cover.on(0,0,0,a);
            }

            switch(this.direction) {
                case 1:
                    $(this.navButton).css( 'transform', 'translate(-50%, '+volume+'px)' );
                    $(this.nav).css( 'transform', 'translate(-50%, '+volume+'px)' );
                    break
                case 2:
                    $(this.navButton).css( 'transform', 'translate('+(-volume)+'px, -50%)' );
                    $(this.nav).css( 'transform', 'translate('+(-volume)+'px, 0)' );
                    break
                case 3:
                    $(this.navButton).css( 'transform', 'translate(-50%, '+(-volume)+'px)' );
                    $(this.nav).css( 'transform', 'translate(-50%, '+(-volume)+'px)' );
                    break
                case 4:
                    $(this.navButton).css( 'transform', 'translate('+volume+'px, -50%)' );
                    $(this.nav).css( 'transform', 'translate('+volume+'px, 0)' );
                    break
            }
        }

        setHide(iHidden) {
            if(iHidden) {
                $(this.container).hide(0);
                this.fAction = false;
                this.setOpen(false);
            } else {
                $(this.container).show(0);
                this.fAction = true;
                this.setOpen(false);
            }
        }

    }

    /**
    *   シングルトン
    */
    class navigationManager {
        static count = 0;
        constructor() {
            if(navigationManager.count >= 1) return;
            navigationManager.count++;
            this.oNavigation = {};
            this.fAnyoneOpen = false;
            this.viewportWidth = window.innerWidth;
            this.viewportHeight = window.innerHeight;
            this.eventRegister();
        }

        eventRegister() {
            let cl = this;
            //-- リサイズされたとき
            $(window).resize(function(){
                cl.viewportWidth = window.innerWidth;
                cl.viewportHeight = window.innerHeight;
                let wid = window.innerWidth;
                Object.values(cl.oNavigation).forEach((nav) => {
                    nav.changeViewport(cl.viewportWidth, cl.viewportHeight);
                });
            });
        }

        add(tagName, direction, toutchSize, navSizeRem) {
            this.oNavigation[tagName] = new navigation(this, tagName, direction, toutchSize, navSizeRem, this.viewportWidth, this.viewportHeight);
        }

        toutchStart( event, posX, posY ) {
            Object.values(this.oNavigation).forEach((nav) => {
                nav.toutchStart( event, posX, posY );
            });
        }

        toutchMove( posX, posY ) {
            Object.values(this.oNavigation).forEach((nav) => {
                nav.toutchMove( posX, posY );
            });
        }

        toutchEnd( posX, posY ) {
            Object.values(this.oNavigation).forEach((nav) => {
                nav.toutchEnd( posX, posY );
            });
        }

        allNonactive() {
            Object.values(this.oNavigation).forEach((nav) => {
                nav.setOpen( false );
            });
        }

        isAnyoneOpen() {
            return fAnyoneOpen;
        }

    }

    ////////////////////// endクラス /////////////////////////////////////////

    $(function() {

        let wid = window.innerWidth;
        var bsSize = wid<576 ? 1 : wid<768 ? 2 : wid<992 ? 3 : wid<1200 ? 4 : wid<1400 ? 5 : 6;

        //#sub-officesが押された時の動作
        $("#sub-offices").click(function(){
            let fas = $(this).find(".fas");
            if( fas.hasClass("fa-chevron-down") ) {
                fas.removeClass("fa-chevron-down");
                fas.addClass("fa-chevron-up");
            } else {
                fas.removeClass("fa-chevron-up");
                fas.addClass("fa-chevron-down");
            }
        });
    });

    //------------ ナビゲーションバーの動作 ------------------------------------------
    var fLeftOpen = false, fRightOpen = false
    // 
    //navigation.setViewportSize(window.innerWidth, window.innerHeight);
    // インスタンス作成
    var navManager = new navigationManager();
    navManager.add( 'left', 4, 16, 20 );
    navManager.add( 'right', 2, 16, 20 );

    $(document).ready(function()
    {
        /** 指が触れたか検知 */
        $(document).on("touchstart", start_check);
    
        /** 指が動いたか検知 */
        $(document).on("touchmove", move_check);
    
        /** 指が離れたか検知 */
        $(document).on("touchend", end_check);
    
        /** 変数宣言 */
        var posX, posY, startPosX, startPosY;
        var viewWidth = window.innerWidth, viewHeight = window.innerHeight;
        //引き出せる限界
        var leftMaxX = viewWidth*0.8, rightMaxX = viewWidth - leftMaxX;
        //反応する幅
        var toutchWidth = 16;
        var fLeftMotion = false, fRightMotion = false;
    
    
        // タッチ開始時の処理
        function start_check(event) 
        {
            /** 現在の座標取得 */
            startPosX = getX(event);
            posX = startPosX;
            startPosY = getY(event);
            posY = startPosY;

            navManager.toutchStart(event, posX, posY);
        }
    
        // スワイプ中の処理
        function move_check(event)
        {
            posX = getX(event);
            posY = getY(event);

            navManager.toutchMove(posX, posY);
        }
    
        // 指が離れた時の処理
        function end_check(event)
        {
            navManager.toutchEnd(posX, posY);
        }
    
        function getX(event) 
        {
            //横方向の座標を取得
            return Math.round(event.originalEvent.touches[0].pageX);
        }
    
        // 座標取得処理
        function getY(event) 
        {
            //縦方向の座標を取得
            return Math.round(event.originalEvent.touches[0].pageY);
        }
    
    });

    /** rem単位をpx単位に変換する **/
    function convertRemToPx(rem) {
        let fontSize = getComputedStyle(document.documentElement).fontSize;
        return rem * parseFloat(fontSize);
    }

</script>

@yield("c_script")
@endsection