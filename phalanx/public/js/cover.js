/*
【準備するHTML例】
<div id="cover" style="position: fixed; top: 0; left: 0; width: 100%; height:100%; z-index: 990; background-color: #00000055" hidden>
</div>
*/


/**
 * コンテンツオーバーレイの制御
 * 静的クラス
 * @auther 藤井淳一
*/
 class cover {
    static fVisible = false;
    static colorA = 0;      // 0～255
    static colorR = 0;
    static colorG = 0;
    static colorB = 0;
    static animation = "all 0s";

    static off(animation=null) {
        cover.fVisible = false;
        cover.colorA = 0;
        if(animation != null) {
            cover.animation = animation;
            $('#cover').css('transition', animation);
        }
        $('#cover').prop('hidden', true);
        $('#cover').css('background-color', 'rgba('+cover.colorR+','+cover.colorG+','+cover.colorB+','+cover.colorA+')');
    }
    static on( r, g, b, a, animation=null ) {
        cover.fVisible = true;
        cover.colorR = r;
        cover.colorG = g;
        cover.colorB = b;
        cover.colorA = Math.round(a/255*100)/100;
        if(animation != null) {
            cover.animation = animation;
            $('#cover').css('transition', animation);
        }
        $('#cover').prop('hidden', false);
        $('#cover').css('background-color', 'rgba('+cover.colorR+','+cover.colorG+','+cover.colorB+','+cover.colorA+')');
    }

    static setAnimation(animation) {
        cover.animation = animation;
        $('#cover').css('transition', animation);
    }
}
