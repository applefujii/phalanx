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
use App\Models\Office;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChatRoomRequest;

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
        $user = Auth::user();

        //ログイン中のユーザーが職員かどうかの判別(職員のuser_type_idを1と仮定)
        if($user->user_type_id == 1) {

            //利用者対職員の個人チャットを取得
            $userRooms = Chat_room::where("distinction_number", 3)->where("office_id", $user->office_id)->whereNotNull("deleted_at")->get();

            //ログイン中のユーザーが参加している部屋一覧を取得
            $joinRooms = Chat_room::join("chat_room__user", "chat_rooms.id", "=", "chat_room__user.chat_room_id")
                ->where("chat_room__user.user_id", $user->id)->whereNull("chat_rooms.deleted_at")->whereNull("chat_room__user.deleted_at")
                    ->whereIn("chat_rooms.distinction_number", [0, 1, 2])->get();

            //事業所一覧を取得
            $offices = Office::whereNull("deleted_at")->orderBy("sort")->get();

            return view("chat_room.index", compact("userRooms", "joinRooms", "offices"));
        }

        //chat_roomsテーブルのuser_idが$userIdと一致するものを検索
        $chatRoom = Chat_room::where("user_id", $user->id)->first();

        return redirect()->route("chat_room.show", $chatRoom->id);
    }

    /**
     * チャットルームの表示
     */
    public function show($id) {
        //chat_roomsテーブルのidと$idが一致するデータを取得
        $chatRoom = Chat_room::where("id", $id)->whereNull("deleted_at")->first();

        //存在しないidを参照したとき残りの処理を飛ばす
        if($chatRoom != null) {
        
            //ログイン中のユーザーのidを取得
            $userId = Auth::id();

            //ログイン中のユーザーがチャットルームに参加しているかどうかの判断
            $join = $chatRoom->chat_room__user()->where("user_id", $userId)->whereNull("deleted_at")->first();

            //参加していない場合残りの処理を飛ばす
            if($join != null) {

                //ログイン中のユーザーが参加している部屋一覧を取得
                $joinRooms = Chat_room__User::where("user_id", $userId)->whereNull("deleted_at")->chat_rooms()
                    ->whereNull("deleted_at")->orderBy("user_id", "desc")->get();

                //事業所一覧を取得
                $offices = Office::whereNull("deleted_at")->orderBy("sort")->get();

                return view("chat_room.show", compact("chatRoom", "joinRooms", "offices"));
            }
        }

        //表示される条件を満たしてなかった場合indexにリダイレクトする
        return redirect()->route("chat_room.index");
    }

    /**
     * チャットルーム管理一覧画面
     */
    public function list() {
        //ログイン中のユーザーデータを取得
        $user = Auth::user();
        
        //ログイン中のユーザーが職員かどうかの判別(職員のuser_type_idを1と仮定)
        if($user->user_type_id != 1) {

            //職員でなければindexにリダイレクト
            return redirect()->route("chat_room.index");
        }

        //表示する部屋の一覧を取得
        $chatRooms = Chat_room::where("distinction_number", 4)->whereNull("offices.deleted_at")->whereNull("chat_rooms.deleted_at")
            ->join("offices", "chat_rooms.office_id", "=", "offices.id")->orderBy("offices.sort")
                ->orderBy("chat_rooms.room_title")->paginate(10);

        // $chatRooms = Chat_room::where("distinction_number", 4)->whereNull("deleted_at")->orderBy("room_title")->paginate(10);

        return view("chat_room/list", compact("chatRooms"));
    }

    /**
     * チャットルームの作成
     */
    public function create() {
        //ログイン中のユーザーデータを取得
        $user = Auth::user();
        
        //ログイン中のユーザーが職員かどうかの判別(職員のuser_type_idを1と仮定)
        if($user->user_type_id != 1) {

            //職員でなければindexにリダイレクト
            return redirect()->route("chat_room.index");
        }

        //必要なユーザーと事業所のデータを取得
        $users = User::whereNull("deleted_at")->get();

        $offices = Office::whereNull("deleted_at")->orderBy("sort")->get();

        return view("chat_room.create", compact("users", "offices"));
    }

    /**
     * チャットルーム作成の実行部分
     */
    public function store(ChatRoomRequest $request) {
        //ログイン中のユーザーデータを取得
        $user = Auth::user();
        
        //ログイン中のユーザーが職員かどうかの判別(職員のuser_type_idを1と仮定)
        if($user->user_type_id != 1) {

            //職員でなければindexにリダイレクト
            return redirect()->route("chat_room.index");
        }

        //各種リクエストのデータを取得
        $roomTitle = $request->input("room_title");
        $officeId = $request->input("office_id");
        $joinUsersId = $request->input("checkBox");

        //現在時刻を取得
        $now = new DateTime("now");
        $now = $now->format("Y-m-d H:i:s");

        //Chat_roomインスタンスを作成、各種データを挿入後登録
        $chatRoom = new Chat_room();
        $chatRoom->room_title = $roomTitle;
        $chatRoom->distinction_number = 4;
        $chatRoom->office_id = $officeId;
        $chatRoom->create_user_id = $user->id;
        $chatRoom->update_user_id = $user->id;
        $chatRoom->created_at = $now;
        $chatRoom->updated_at = $now;
        $chatRoom->save();

        //今作成したチャットルームのidを取得
        $lastChatRoomId = Chat_room::select("id")->last();

        //チャット参加者ごとにチャットルーム-ユーザー中間テーブルのデータを作成
        foreach($joinUsersId as $joinUserId) {
            $chatRoomUser = new Chat_room__User();
            $chatRoomUser->chat_room_id = $lastChatRoomId;
            $chatRoomUser->user_id = $joinUserId;
            $chatRoomUser->create_user_id = $user->id;
            $chatRoomUser->update_user_id = $user->id;
            $chatRoomUser->created_at = $now;
            $chatRoomUser->updated_at = $now;
            $chatRoomUser->save();
        }

        return redirect()->route("chat_room.list");
    }

    /**
     * チャットルームの編集
     */
    public function edit($id) {
        //ログイン中のユーザーデータを取得
        $user = Auth::user();
        
        //ログイン中のユーザーが職員かどうかの判別(職員のuser_type_idを1と仮定)
        if($user->user_type_id != 1) {

            //職員でなければindexにリダイレクト
            return redirect()->route("chat_room.index");
        }

        //編集するチャットルームのデータを取得
        $chatRoom = Chat_room::where("id", $id)->whereNull("deleted_at")->first();

        //存在しないチャットルームを編集しようとした時listにリダイレクト
        if($chatRoom == null) {
            return redirect()->route("chat_room.list");
        }

        //必要なユーザーと事業所のデータを取得
        $users = User::whereNull("deleted_at")->get();
        $offices = Office::whereNull("deleted_at")->orderBy("sort")->get();

        return view("chat_room.edit", compact("chatRoom", "users", "offices"));
    }

    /**
     * チャットルーム編集の実行部分
     */
    public function update(ChatRoomRequest $request, $id) {
        //ログイン中のユーザーデータを取得
        $user = Auth::user();
        
        //ログイン中のユーザーが職員かどうかの判別(職員のuser_type_idを1と仮定)
        if($user->user_type_id != 1) {

            //職員でなければindexにリダイレクト
            return redirect()->route("chat_room.index");
        }

        //編集するチャットルームのデータを取得
        $chatRoom = Chat_room::where("id", $id)->whereNull("deleted_at")->first();

        //存在しないチャットルームを編集しようとした時listにリダイレクト
        if($chatRoom == null) {
            return redirect()->route("chat_room.list");
        }

        //各種リクエストのデータを取得
        $roomTitle = $request->input("room_title");
        $officeId = $request->input("office_id");
        $joinUsersId = $request->input("checkBox");

        //現在時刻を取得
        $now = new DateTime("now");
        $now = $now->format("Y-m-d H:i:s");

        //取得したデータを用いて各種データを更新
        $chatRoom->room_title = $roomTitle;
        $chatRoom->office_id = $officeId;
        $chatRoom->update_user_id = $user->id;
        $chatRoom->updated_at = $now;
        $chatRoom->save();

        //$joinUsersIdを用いて変更後に参加者となっていないユーザーの中間テーブルを取得し、データを削除
        $chatRoomUsers = Chat_room__User::where("chat_room_id", $id)->whereNull("deleted_at")->whereNotIn("user_id", $joinUsersId)->get();
        foreach($chatRoomUsers as $chatRoomUser) {
            $chatRoomUser->delete_user_id = $user->id;
            $chatRoomUser->deleted_at = $now;
            $chatRoomUser->save();
        }

        //変更された参加者とルームを結びつける中間テーブルのデータがすでにあるかどうかを判別
        foreach($joinUsersId as $joinUserId) {
            $serch = Chat_room__User::whereNull("deleted_at")->where("chat_room_id", $id)->where("user_id", $joinUserId)->first();

            //中間テーブルにデータがまだない場合のみ作成
            if(is_null($serch)) {
                $chatRoomUser = new Chat_room__User();
                $chatRoomUser->chat_room_id = $id;
                $chatRoomUser->user_id = $joinUserId;
                $chatRoomUser->create_user_id = $user->id;
                $chatRoomUser->update_user_id = $user->id;
                $chatRoomUser->created_at = $now;
                $chatRoomUser->updated_at = $now;
                $chatRoomUser->save();
            }
        }

        return redirect()->route("chat_room.list");
    }
}
