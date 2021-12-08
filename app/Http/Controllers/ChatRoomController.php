<?php

/**
 * チャットルーム表示用のコントローラ
 * 
 * @author Kakeru Kusada
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatRoom;
use App\Models\ChatRoom__User;
use App\Models\ChatText;
use App\Models\Office;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ChatRoomRequest;
use Carbon\Carbon;

class ChatRoomController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct() {

        //ログインしているユーザーが職員かどうかの判断
        $this->middleware("staff");
    }

    /**
     * チャットルーム管理一覧画面
     */
    public function index() {
        
        //表示する部屋の一覧を取得
        $chatRooms = ChatRoom::where("distinction_number", 4)->whereNull("offices.deleted_at")->whereNull("chat_rooms.deleted_at")
            ->leftJoin("offices", "chat_rooms.office_id", "=", "offices.id")->orderBy("offices.sort")
                ->orderBy("chat_rooms.room_title")->select("chat_rooms.*")->paginate(10);


        return view("chat_room/index", compact("chatRooms"));
    }

    /**
     * チャットルームの作成
     */
    public function create() {

        //必要なユーザーと事業所のデータを取得
        $users = User::whereNull("deleted_at")->get();

        $offices = Office::whereNull("deleted_at")->orderBy("sort")->get();

        return view("chat_room.create", compact("users", "offices"));
    }

    /**
     * チャットルーム作成の受け取り部分
     */
    public function store(ChatRoomRequest $request) {

        $id = $this->storeDetail($request);

        return redirect()->route("chat_room.index");
    }

    /**
     * チャットルーム作成の実行部分
     * @param Request $request
     * @return int id
     */
    public function storeDetail(Request $request) {

        //ログイン中のユーザーデータを取得
        $user = Auth::user();
        
        //各種リクエストのデータを取得
        $roomTitle = $request->input("room_title");
        $officeId = $request->input("office_id");
        $targetUsers = $request->input("target_users");
        if(isset($targetUsers))
            $joinUsersId = explode(",", $targetUsers);

        //現在時刻を取得
        $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');

        //データをデータベースに登録
        $chatRoom = null;
        DB::transaction(function () use($user, $roomTitle, $officeId, $joinUsersId, $now) {
            $chatRoom = ChatRoom::create([
                "room_title" => $roomTitle,
                "distinction_number" => 4,
                "office_id" => $officeId,
                "create_user_id" => $user->id,
                "update_user_id" => $user->id,
                "created_at" => $now,
                "updated_at" => $now
            ]);

            if(isset($joinUsersId)) {
                $aItem = [];
                foreach($joinUsersId as $joinUserId) {
                    array_push($aItem, [
                        "chat_room_id" => $chatRoom->id,
                        "user_id" => $joinUserId,
                        "create_user_id" => $user->id,
                        "update_user_id" => $user->id,
                        "created_at" => $now,
                        "updated_at" => $now
                    ]);
                }

                $aChunk = array_chunk($aItem, 100);
                foreach($aChunk as $chunk) {
                    ChatRoom__User::insert($chunk);
                }
            }
        });

        if(isset($chatRoom)) return $chatRoom->id;
        return -1;
    }

    /**
     * チャットルームの編集
     */
    public function edit($id) {

        //編集するチャットルームのデータを取得
        $chatRoom = ChatRoom::where("id", $id)->whereNull("deleted_at")->first();

        //存在しないチャットルームを編集しようとした時listにリダイレクト
        if($chatRoom == null) {
            return redirect()->route("chat_room.index");
        }

        //必要なユーザーと事業所のデータを取得
        $users = User::whereNull("deleted_at")->get();
        $offices = Office::whereNull("deleted_at")->orderBy("sort")->get();

        $aTargetUsers = $chatRoom->chat_room__user->map(function ($chat_room__user) {
            return $chat_room__user->user->id;
        });

        return view("chat_room.edit", compact("chatRoom", "users", "offices", "aTargetUsers"));
    }

    /**
     * チャットルーム編集の実行部分
     */
    public function update(ChatRoomRequest $request, $id) {

        //ログイン中のユーザーデータを取得
        $user = Auth::user();
        
        //編集するチャットルームのデータを取得
        $chatRoom = ChatRoom::where("id", $id)->whereNull("deleted_at")->first();

        //存在しないチャットルームを編集しようとした時listにリダイレクト
        if(is_null($chatRoom)) {
            return redirect()->route("chat_room.index");
        }

        //各種リクエストのデータを取得
        $roomTitle = $request->input("room_title");
        $officeId = $request->input("office_id");
        $targetUsers = $request->input("target_users");
        $joinUsersId = explode(",", $targetUsers);

        //現在時刻を取得
        $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');

        //取得したデータを用いて各種データを更新
        $chatRoom->room_title = $roomTitle;
        $chatRoom->office_id = $officeId;
        $chatRoom->update_user_id = $user->id;
        $chatRoom->updated_at = $now;
        $chatRoom->save();

        //$joinUsersIdを用いて変更後に参加者となっていないユーザーの中間テーブルを取得し、データを削除
        $chatRoomUsers = ChatRoom__User::where("chat_room_id", $id)->whereNotIn("user_id", $joinUsersId)->get();
        foreach($chatRoomUsers as $chatRoomUser) {
            $chatRoomUser->delete();
        }

        //変更された参加者とルームを結びつける中間テーブルのデータがすでにあるかどうかを判別
        foreach($joinUsersId as $joinUserId) {
            $serch = ChatRoom__User::where("chat_room_id", $id)->where("user_id", $joinUserId)->first();

            //中間テーブルにデータがまだない場合は作成
            if(is_null($serch)) {
                $chatRoomUser = new ChatRoom__User();
                $chatRoomUser->chat_room_id = $id;
                $chatRoomUser->user_id = $joinUserId;
                $chatRoomUser->create_user_id = $user->id;
                $chatRoomUser->update_user_id = $user->id;
                $chatRoomUser->created_at = $now;
                $chatRoomUser->updated_at = $now;
                $chatRoomUser->save();
            }
        }

        return redirect()->route("chat_room.index");
    }

    /**
     * チャットルーム削除の実行部分
     */
    public function destroy($id) {
        
        //ログイン中のユーザーデータを取得
        $user = Auth::user();
        
        //削除するチャットルームのデータを取得
        $chatRoom = ChatRoom::where("id", $id)->whereNull("deleted_at")->first();

        //存在しないチャットルームを削除しようとした時listにリダイレクト
        if(is_null($chatRoom)) {
            return redirect()->route("chat_room.index");
        }

        //現在時刻を取得
        $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');

        //チャットルームテーブルのデータの削除を実行
        $chatRoom->delete_user_id = $user->id;
        $chatRoom->deleted_at = $now;
        $chatRoom->save();

        //削除するチャットルーム-ユーザー中間テーブルのデータを取得
        $chatRoomUsers = ChatRoom__User::where("chat_room_id", $id)->get();

        //削除を実行
        if(isset($chatRoomUsers)) {
            foreach($chatRoomUsers as $chatRoomUser) {
                $chatRoomUser->delete();
            }
        }

        //削除するチャットテキストテーブルのデータを取得
        $chatTexts = ChatText::whereNull("deleted_at")->where("chat_room_id", $id)->get();

        //削除するデータが存在する場合のみ削除を実行
        if(isset($chatTexts)) {
            foreach($chatTexts as $chatText) {
                $chatText->delete_user_id = $user->id;
                $chatText->deleted_at = $now;
            }
        }

        return redirect()->route("chat_room.index");
    }
}
