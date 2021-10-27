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
use App\Models\Chat_room__User;
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
        $chatRoom = Chat_room::where("id", $id)->whereNull("deleted_at")->first();

        //存在しないidを参照したとき残りの処理を飛ばす
        if($chatroom != null) {
        
            //ログイン中のユーザーのidを取得
            $userId = Auth::id();

            //ログイン中のユーザーがチャットルームに参加しているかどうかの判断
            $join = $chatRoom->chat_room__user()->where("user_id", $userId)->whereNull("deleted_at")->first();

            //参加していない場合残りの処理を飛ばす
            if($join != null) {

                //ログイン中のユーザーが参加している部屋一覧を取得
                $chatRooms = Chat_room__User::where("user_id", $userId)->whereNull("deleted_at")->chat_rooms()->whereNull("deleted_at")->get();

                return view("chat_room.index", compact("chatRoom", "chatRooms"));
            }
        }

        //表示される条件を満たしてなかった場合indexにリダイレクトする
        return redirect()->route("chat_rooms.index");
    }
}
