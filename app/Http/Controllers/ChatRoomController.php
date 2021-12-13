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
        $distinctionNumber = $request->input("distinction_number", 4);
        $officeId = $request->input("office_id");
        $userId = $request->input("user_id", null);
        $targetUsers = $request->input("target_users");
        if(isset($targetUsers))
            $joinUsersId = explode(",", $targetUsers);

        //現在時刻を取得
        $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');

        //データをデータベースに登録
        $chatRoom = null;
        DB::transaction(function () use(&$chatRoom, $user, $roomTitle, $distinctionNumber, $officeId, $userId, $joinUsersId, $now) {
            $chatRoom = ChatRoom::create([
                "room_title" => $roomTitle,
                "distinction_number" => $distinctionNumber,
                "office_id" => $officeId,
                "user_id" => $userId,
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
     * チャットルーム編集の受け取り部分
     */
    public function update(ChatRoomRequest $request, $id) {

        $id = $this->updateDetail($request, $id);

        return redirect()->route("chat_room.index");
    }

    /**
     * チャットルーム更新の実行部分
     * @param Request $request
     * @return int id
     */
    public function updateDetail(Request $request, $id) {

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
        DB::transaction(function() use(&$chatRoom, $id, $user, $roomTitle, $officeId, $joinUsersId, $now) {
            $chatRoom = ChatRoom::where("id", $id)->update([
                "room_title" => $roomTitle,
                "office_Id" => $officeId,
                "update_user_id" => $user->id,
                "updated_at" => $now
            ]);

            //参加者から外されたユーザーのデータを中間テーブルから削除
            ChatRoom__User::where("chat_room_id", $id)->whereNotIn("user_id", $joinUsersId)->delete();

            $aItem = [];
            foreach($joinUsersId as $joinUserId) {
                $find = ChatRoom__User::where("chat_room_id", $id)->where("user_id", $joinUserId)->first();
                if($find != null) continue;
                array_push($aItem, [
                    "chat_room_id" => $id,
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
        });

        if(isset($chatRoom)) return $id;
        return -1;
    }

    /**
     * チャットルーム削除の実行部分
     */
    public function destroy($id) {
        
        //ログイン中のユーザーデータを取得
        $user = Auth::user();

        //現在時刻を取得
        $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');

        DB::transaction(function () use($id, $user, $now) {

            //チャットルームを削除
            ChatRoom::where("id", $id)->update([
                "delete_user_id" => $user->id,
                "deleted_at" => $now
            ]);

            //関連するチャットルーム-ユーザー中間テーブルを削除
            $chatRoomUsers = ChatRoom__User::where("chat_room_id", $id)->delete();

            //削除するチャットテキストテーブルのデータを取得
            $chatTexts = ChatText::whereNull("deleted_at")->where("chat_room_id", $id)->get();

            //削除するデータが存在する場合のみ削除を実行
            if(isset($chatTexts)) {
                $chatTexts->update([
                    "delete_user_id" => $user->id,
                    "deleted_at" => $now
                ]);
            }
        });

        return redirect()->route("chat_room.index");
    }
}
