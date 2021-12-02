/**
 * タッチ情報
 * シングルトン
 * タッチ時、スワイプ時、タップを離したときに動作するコールバックを登録することができる。
 * @auther 藤井淳一
*/
 class toutchInfo {
    static count = 0;
    constructor( pastNum ) {
        if(toutchInfo.count >= 1) return;
        toutchInfo.count++;
        // 過去の座標を保持する数
        this.pastNum = pastNum;
        // 座標(過去pastNum回分)
        this.aPosX = [], this.aPosY = [];
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
        $(document).on("touchstart", this.toutchStart.bind(this));
        /** 指が動いたか検知 */
        $(document).on("touchmove", this.toutchMove.bind(this));
        /** 指が離れたか検知 */
        $(document).on("touchend", this.toutchEnd.bind(this));
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

    toutchStart( event ) {
        this.aPosX = [], this.aPosY = [];
        this.aPosX.push(this.getX(event));
        this.aPosY.push(this.getY(event));

        this.aStartCallBack.forEach( (e, index) => {
            e.call(this.aStartCallBackClass[index], event, this);
        });
    }

    toutchMove( event ) {
        if( this.aPosX.length >= this.pastNum ) this.aPosX.shift();
        if( this.aPosY.length >= this.pastNum ) this.aPosY.shift();
        this.aPosX.push(this.getX(event));
        this.aPosY.push(this.getY(event));

        this.aMoveCallBack.forEach( (e, index) => {
            e.call(this.aMoveCallBackClass[index], event, this);
        });
    }

    toutchEnd( event ) {
        this.aEndCallBack.forEach( (e, index) => {
            e.call(this.aEndCallBackClass[index], event, this);
        });
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
