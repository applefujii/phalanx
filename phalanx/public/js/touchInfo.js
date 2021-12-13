/**
 * タッチ情報
 * シングルトン
 * タッチ時、スワイプ時、タップを離したときに動作するコールバックを登録することができる。
 * @auther 藤井淳一
*/
 class touchInfo {
    static count = 0;
    constructor( pastNum ) {
        if(touchInfo.count >= 1) return;
        touchInfo.count++;
        // タッチ開始座標
        this.startX = null, this.startY = null;
        // スワイプ速度
        this.speedX = null, this.speedY = null;
        // タッチ開始座標から移動した量
        this.amountMovementX = null, this.amountMovementY = null;
        // 過去の座標を保持する数
        this.pastNum = pastNum;
        // 座標(過去pastNum回分)
        this.aPosX = [], this.aPosY = [];
        // 座標(過去pastNum回分)定期的に0を挿入する
        this.aPosX0 = [], this.aPosY0 = [];
        // スワイプ開始時の向き(1上 2右 3下 4左)
        this.swipeDirection = null;
        //-- コールバックとコールバックのクラス。コールバックのクラスは保持して渡してやらないと、渡し先のthisがundefinedになるため必要。
        this.aStartCallBack = [];
        this.aStartCallBackClass = [];
        this.aMoveCallBack = [];
        this.aMoveCallBackClass = [];
        this.aEndCallBack = [];
        this.aEndCallBackClass = [];

        this.eventRegister();
    }

    //-- イベント登録
    eventRegister() {
        /** 指が触れたか検知 */
        $(document).on("touchstart", this.touchStart.bind(this));
        /** 指が動いたか検知 */
        $(document).on("touchmove", this.touchMove.bind(this));
        /** 指が離れたか検知 */
        $(document).on("touchend", this.touchEnd.bind(this));
        /** 定期実行 */
        setInterval(() => {
            this.positionInsertZero();
        }, 100);
    }


    //---------- 動作を登録

    addStartCallBack( callback, thisClass ) {
        this.aStartCallBack.push(callback);
        this.aStartCallBackClass.push(thisClass);
    }
    addMoveCallBack( callback, thisClass ) {
        this.aMoveCallBack.push(callback);
        this.aMoveCallBackClass.push(thisClass);
    }
    addEndCallBack( callback, thisClass ) {
        this.aEndCallBack.push(callback);
        this.aEndCallBackClass.push(thisClass);
    }


    //------------- 各種イベント時の動作

    touchStart( event ) {
        this.startX = this.getX(event);
        this.startY = this.getY(event);
        this.speedX = 0; this.speedY = 0;
        this.amountMovementX = 0, this.amountMovementY = 0;
        this.aPosX = [], this.aPosY = [];
        this.aPosX.push(this.getX(event));
        this.aPosY.push(this.getY(event));
        this.aPosX0 = [], this.aPosY0 = [];
        this.aPosX0.push(this.getX(event));
        this.aPosY0.push(this.getY(event));

        this.aStartCallBack.forEach( (e, index) => {
            e.call(this.aStartCallBackClass[index], event, this);
        });
    }

    touchMove( event ) {
        this.amountMovementX = this.getX(event) - this.startX;
        this.amountMovementY = this.getY(event) - this.startY;
        if( this.aPosX.length >= this.pastNum ) this.aPosX.shift();
        if( this.aPosY.length >= this.pastNum ) this.aPosY.shift();
        this.aPosX.push(this.getX(event));
        this.aPosY.push(this.getY(event));
        if( this.aPosX0.length >= this.pastNum ) this.aPosX0.shift();
        if( this.aPosY0.length >= this.pastNum ) this.aPosY0.shift();
        this.aPosX0.push(this.getX(event));
        this.aPosY0.push(this.getY(event));
        this.speedX = (this.aPosX0[this.aPosX0.length-1] - this.aPosX0[0]) /this.aPosX0.length;
        this.speedY = (this.aPosY0[this.aPosY.length-1] - this.aPosY0[0]) /this.aPosY0.length;

        if( this.swipeDirection == null ) {
            if(Math.abs(this.amountMovementX) >= Math.abs(this.amountMovementY)) {
                if(this.amountMovementX >= 0) this.swipeDirection = 2;
                else this.swipeDirection = 4;
            } else {
                if(this.amountMovementY >= 0) this.swipeDirection = 3;
                else this.swipeDirection = 1;
            }
        }

        this.aMoveCallBack.forEach( (e, index) => {
            e.call(this.aMoveCallBackClass[index], event, this);
        });
    }

    touchEnd( event ) {
        this.aEndCallBack.forEach( (e, index) => {
            e.call(this.aEndCallBackClass[index], event, this);
        });
        this.startX = null; this.startY = null;
        this.speedX = null; this.speedY = null;
        this.amountMovementX = null, this.amountMovementY = null;
        this.aPosX = [], this.aPosY = [];
        this.aPosX0 = [], this.aPosY0 = [];
        this.swipeDirection = null;
    }

    positionInsertZero() {
        if( this.aPosX0.length >= this.pastNum ) this.aPosX0.shift();
        if( this.aPosY0.length >= this.pastNum ) this.aPosY0.shift();
        this.aPosX0.push(0);
        this.aPosY0.push(0);
    }


    //------ eventから座標取得

    getX(event) 
    {
        //横方向の座標を取得
        return Math.round(event.originalEvent.touches[0].pageX);
    }

    getY(event) 
    {
        //縦方向の座標を取得
        return Math.round(event.originalEvent.touches[0].pageY);
    }
}
