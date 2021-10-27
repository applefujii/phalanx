<?php

/**
 * チャットルーム表示用のコントローラ
 * 
 * @author Kakeru Kusada
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat_room;
use Illuminate\Support\Facades\Auth;

class ChatRoomController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct() {
        //ログインしているかどうかの判断
        $this->middleware("auth");
    }

    /**
     * どのチャットを最初に表示するかの判断
     */
    public function index() {
        //ログイン中のユーザーのidを取得
        $userId = Auth::id();

        //chat_roomsテーブルのuser_idが$userIdと一致するものを検索
        $chatRoom = Chat_room::where("user_id", $userId)->first();

        return redirect()->route("chat_rooms.show", $chatRoom->id());
    }

    /**
     * チャットルームの表示
     */
    public function show($id) {
        //chat_roomsテーブルのidと$idが一致するデータを取得
        $chatRoom = Chat_room::where("id", $id)->first();

        //存在しないidを参照したとき残りの処理を飛ばす
        if($chatroom != null) {
        
            //ログイン中のユーザーのidを取得
            $userId = Auth::id();

            //ログイン中のユーザーがチャットルームに参加しているかどうかの判断
            $join = $chatRoom->chat_room__user()->where("user_id", $userId)->first();

            //参加している場合のみ表示する
            if($join != null) {
                return view("chat_room.index", compact("chatRoom"));
            }
        }

        //表示される条件を満たしてなかった場合indexにリダイレクトする
        return redirect()->route("chat_rooms.index");
    }
}
