/*
【準備するHTML例(画面左の場合)】 場所に応じてleft部分を置換する。bootstrapのsm以下で表示
<div id="nav-left-container" class="d-block d-md-none" style='visibility: hidden'>
    <div id="nav-button-left" class="nav-button openbtn d-flex align-items-center justify-content-end" data-is-open="false"><i class="fas fa-chevron-right"></i></div>
    <nav id="nav-left" class="edge-nav">
        ※ここに表示内容を入れる
    </nav>
</div>
*/

/**
 * 画面端から引き出すナビゲーションの管理クラス
 * シングルトン
 * @auther 藤井淳一
*/
class navigationManager {
    static count = 0;
    //-- コンストラクタ
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
        $('#nav-'+tagName+'-container').css('visibility', 'visible');
    }

    toutchStart( event, clToutch ) {
        Object.values(this.oNavigation).forEach((nav) => {
            nav.toutchStart( event, clToutch.aPosX, clToutch.aPosY );
        });
    }

    toutchMove( event, clToutch ) {
        Object.values(this.oNavigation).forEach((nav) => {
            nav.toutchMove( event, clToutch.aPosX, clToutch.aPosY );
        });
    }

    toutchEnd( event, clToutch ) {
        Object.values(this.oNavigation).forEach((nav) => {
            nav.toutchEnd( event, clToutch.aPosX, clToutch.aPosY );
        });
    }

    allNonactivate() {
        Object.values(this.oNavigation).forEach((nav) => {
            nav.setOpen( false );
        });
    }

    isAnyoneOpen() {
        return this.fAnyoneOpen;
    }

    setAnyoneOpen( flag ) {
        this.fAnyoneOpen = flag;
    }

}




/**
 * 画面端から引き出すナビゲーション
 * @auther 藤井淳一
*/
 class navigation {
    //-- コンストラクタ
    constructor(manager, tagName, direction, toutchSize, navSizeRem, vW, vH) {
        // マネージャークラス
        this.manager = manager;
        //-- 操作する要素のID
        this.navButton= '#nav-button-'+tagName, this.nav= '#nav-'+tagName;
        this.container = '#nav-'+tagName+'-container';
        // 向き
        this.direction= direction;
        this.toutchSize= toutchSize;
        this.navSizeRem = navSizeRem;
        let fontSize = getComputedStyle(document.documentElement).fontSize;
        this.navSizePixel = navSizeRem * parseFloat(fontSize);
        //-- 向きに応じてどの座標まで展開できるかを代入
        if(direction==1) this.max= this.navSizePixel;
        else if(direction==2) this.max= vW-this.navSizePixel;
        else if(direction==3) this.max= vH-this.navSizePixel;
        else if(direction==4) this.max= this.max= this.navSizePixel;
        // 開いているか、動かしているか
        this.fOpen= false, this.fInMotion= false;
        // このナビゲーションが有効か
        this.fEnable = false;
        this.changeViewport( vW, vH )
        this.eventRegister();
    }

    //-- イベント登録
    eventRegister() {
        let cl = this;
        //------ クリック時の動作
        $(document).on('click', this.navButton, function(){
            console.log('click navButton');
            if( $(cl.navButton).data('is-open') == 'true' ) cl.setOpen(false, true);
            else cl.setOpen(true, true);
        });
        $(document).on('click', this.nav+' a', function() {
            console.log('clicl a');
            cl.setOpen(false, true);
        });
    }

    //-- タッチした時
    toutchStart( event, aPosX, aPosY ) {
        if(this.fEnable == false) return;
        let posX = aPosX[0];
        let posY = aPosY[0];

        //-- 開いていない状態で画面端タッチなら動作させる。開いた状態で他部分をタッチしたら動作させる。
        switch(this.direction) {
            case 1:
                break
            case 2:
                if( !this.manager.fAnyoneOpen  &&  !this.fOpen  &&  posX >= (this.manager.viewportWidth-this.toutchSize)) {
                    this.fInMotion = true;
                }
                else if( this.fOpen ) {
                    if( !$(event.target).closest(this.navButton).length  &&  !$(event.target).closest(this.nav).length ) {
                        this.fInMotion = true;
                        this.setOpen(false);

                        let x = this.manager.viewportWidth-posX;
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
                if( !this.manager.fAnyoneOpen  &&  !this.fOpen  &&  posX <= this.toutchSize) {
                    this.fInMotion = true;
                }
                else if( this.fOpen ) {
                    if( !$(event.target).closest(this.navButton).length  &&  !$(event.target).closest(this.nav).length ) {
                        this.fInMotion = true;
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
    toutchMove( event, aPosX, aPosY ) {
        if(!this.fInMotion) return;
        let posX = aPosX[0];
        let posY = aPosY[0];

        switch(this.direction) {
            case 1:
                break
            case 2:
                if(this.fInMotion) {
                    let x = this.manager.viewportWidth-posX;
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
    toutchEnd( event, aPosX, aPosY ) {
        if(!this.fInMotion) return;
        let posX = aPosX[0];
        let posY = aPosY[0];
        
        //-- 速度が一定以上ならfOpenをtrueにする
        let speedX = (aPosX[aPosX.length-1] - aPosX[0]) /aPosX.length;
        let speedY = (aPosY[aPosY.length-1] - aPosY[0]) /aPosY.length;
        let fSpeed = false;
        switch(this.direction) {
            case 1:
                break
            case 2:
                if(aPosX.length>=2) {
                    if(speedX <= -2.0) {
                        this.fOpen = true;
                        fSpeed = true;
                    }
                } else {
                    if(this.fOpen == true) this.fOpen = false;
                }
                break
            case 3:
                break
            case 4:
                if(aPosX.length>=2) {
                    if(speedX >= 2.0) {
                        this.fOpen = true;
                        fSpeed = true;
                    }
                } else {
                    if(this.fOpen == true) this.fOpen = false;
                }
                break
        }

        if( this.fOpen ) {
            if( fSpeed ) this.setOpen(true, true);
            else this.setOpen(true, false);
        } else {
            this.setOpen(false, true);
        }
        this.setTransform( 0 );

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
        // console.log('dir:'+this.direction+'/ active:'+iActive+'/ anim:'+iAnimation);
        if(iAnimation) this.setTransition('all .6s');
        else this.setTransition('all 0s');

        if(iActive) {
            if(this.manager.fAnyoneOpen) return;
            $(this.navButton).addClass('active');
            $(this.nav).addClass('panelactive');
            cover.on(0,0,0,88);
            this.fOpen = true;
            this.manager.setAnyoneOpen(true);
            $(this.navButton).data('is-open', 'true');
        } else {
            if(!this.fOpen) return;
            $(this.navButton).removeClass('active');
            $(this.nav).removeClass('panelactive');
            cover.on(0,0,0,0);
            let cl = this;
            setTimeout(function() {
                cover.off();
                cl.manager.setAnyoneOpen(false);
            }, 600);
            this.fOpen = false;
            $(this.navButton).data('is-open', 'false');
        }
    }

    setTransition(value) {
        $(this.navButton).css( 'transition', value );
        $(this.nav).css( 'transition', value );
        cover.setAnimation(value);
    }

    setTransform( volume ) {
        let a = volume/2;
        if(a > 88) a = 88;
        if(this.fOpen) cover.on(0,0,0,88)
        else {
            if(volume > 0) {
                this.setTransition('all 0s');
                cover.on(0,0,0,a);
            }
            else cover.off();
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
            this.fEnable = false;
            this.setOpen(false);
        } else {
            $(this.container).show(0);
            this.fEnable = true;
            this.setOpen(false);
        }
    }

}