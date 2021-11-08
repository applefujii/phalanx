<?php
/**
 * 職員権限
 * 
 * @author Fumio Mochizuki
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Staff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //ユーザーがログインしていない場合は、トップ画面へリダイレクト
        if( empty( auth()->user() ) ){
            return redirect()->route('top');
        }
 
        //権限チェック
        if (auth()->user()->user_type_id === 1) {
            $this->auth = true;
        } else {
            $this->auth = false;
        }
 
        if ($this->auth === true) {
            //職員の場合はアクセスを許可
            return $next($request);
        } else {
            //それ以外はホーム画面にリダイレクト
            return redirect()->route('home')->with('error', '権限がありません。');
        }
    }
}
