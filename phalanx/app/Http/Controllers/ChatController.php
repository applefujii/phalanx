<?php

/**
 * チャット画面用のコントローラ
 * 
 * @author Fumio Mochizuki
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChatTextRequest;
use App\Models\ChatRoom;
use App\Models\ChatText;
use App\Models\ChatRoom__User;
use App\Models\Office;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChatController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct() {
        $this->middleware("auth");// ログイン認証
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
            $userRooms = ChatRoom::where("distinction_number", 3)->where("office_id", $user->office_id)->whereNotNull("deleted_at")->get();

            //職員全体のチャットルームを取得
            $group = ChatRoom::where("distinction_number", 0)->whereNull("deleted_at")->first();

            //ログイン中のユーザーが参加している部屋一覧を取得
            $joinRooms = ChatRoom::join("chat_room__user", "chat_rooms.id", "=", "chat_room__user.chat_room_id")
                ->where("chat_room__user.user_id", $user->id)->whereNull("chat_rooms.deleted_at")->whereNull("chat_room__user.deleted_at")
                    ->whereIn("chat_rooms.distinction_number", [1, 2, 4])->orderBy("chat_rooms.distinction_number")->get();

            //事業所一覧を取得
            $offices = Office::whereNull("deleted_at")->orderBy("sort")->get();

            //chat_room.indexが出来次第変える
            return view("chat.index", compact("userRooms", "group", "joinRooms", "offices"));
        }

        //chat_roomsテーブルのuser_idが$userIdと一致するものを検索
        $chatRoom = ChatRoom::where("user_id", $user->id)->first();

        return redirect()->route("chat.show", $chatRoom->id);
    }

    /**
     * チャット画面を表示
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chat_room = ChatRoom::whereNull('deleted_at')->findOrFail($id);
        //ログイン中のユーザーのidを取得
        $user = Auth::user();

        //職員とそれ以外でサイドバーに必要なデータが異なるので場合分け
        if($user->user_type_id == 1) {

            //職員全体のチャットルームを取得
            $group = ChatRoom::where("distinction_number", 0)->whereNull("deleted_at")->first();

            //ログイン中のユーザーが参加している部屋一覧を取得
            $joinRooms = ChatRoom::join("chat_room__user", "chat_rooms.id", "=", "chat_room__user.chat_room_id")
                ->where("chat_room__user.user_id", $user->id)->whereNull("chat_rooms.deleted_at")->whereNull("chat_room__user.deleted_at")
                    ->whereIn("chat_rooms.distinction_number", [1, 2, 4])->orderBy("chat_rooms.distinction_number")->get("chat_rooms.*");
        } else {

            //issetでfalseを返すようにnullを入れる
            $group = null;

            //ログイン中のユーザーが参加している部屋一覧を取得
            $joinRooms = ChatRoom::join("chat_room__user", "chat_rooms.id", "=", "chat_room__user.chat_room_id")
                ->where("chat_room__user.user_id", $user->id)->whereNull("chat_rooms.deleted_at")->whereNull("chat_room__user.deleted_at")
                    ->whereIn("chat_rooms.distinction_number", [3, 4])->orderBy("chat_rooms.distinction_number")->get("chat_rooms.*");
        }
        //事業所一覧を取得
        $offices = Office::whereNull("deleted_at")->orderBy("sort")->get();

        return view('chat/show', compact('chat_room', "group", "joinRooms", "offices"));
    }

    /**
     * 一斉送信されたチャットをDBに保存
     * 
     * @param \App\Http\Requests\ChatTextRequest $request
     * @return \Illuminate\http\Response
     */
    public function multiStore(ChatTextRequest $request) {

        //現在時刻の取得
        $now = Carbon::now();

        //Requestから渡されたchat-roomsを配列に変換し、foreachで処理を回す
        $chatRooms = $request->input("chat_rooms");
        $roomsId = explode(",", $chatRooms);
        foreach($roomsId as $roomId) {

            //各種データを挿入
            $chat_text = new ChatText();
            $chat_text->chat_text = $request->input("chat_text");
            $chat_text->chat_room_id = $roomId;
            $chat_text->user_id = Auth::user()->id;
            $chat_text->create_user_id = Auth::user()->id;
            $chat_text->update_user_id = Auth::user()->id;
            $chat_text->created_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
            $chat_text->updated_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
            $chat_text->save();
        }

        return redirect()->route("chat_room.index");
    }

    /**
     * チャットログをjavascriptで取得
     * 
     * @param チャットルームテーブルのID $id
     * @return json $chat_room
     */
    public function getChatLogJson ($id)
    {
        // チャットルーム-ユーザー-中間テーブルから、既読チャットテキストIDを取得
        $chat_room__user = ChatRoom__User::where('chat_room_id', $id)->where('user_id', Auth::user()->id)->first();
        $newest_read_chat_text_id = $chat_room__user->newest_read_chat_text_id;

        // 全てのチャットテキストを取得
        $chat_room = ChatRoom::whereNull('deleted_at')->with('chat_texts')->find($id);

        $chat_room_array = $chat_room->toArray();

        // 既読チャットテキストIDを戻り値に追加
        $chat_room_array += array('newest_read_chat_text_id' => $newest_read_chat_text_id);

        // チャットルーム-ユーザー-中間テーブルに、既読チャットテキストIDを保存
        $now = Carbon::now();

        $chat_room__user->newest_read_chat_text_id = $chat_room->chat_texts->last()->id;
        $chat_room__user->update_user_id = Auth::user()->id;
        $chat_room__user->updated_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
        $chat_room__user->save();

        return response()->json($chat_room_array);
    }

    /**
     * チャットログの差分をjavascriptで取得
     * 
     * @param チャットルームテーブルのID $id
     * @return json $chat_room
     */
    public function getNewChatLogJson ($id)
    {
        // チャットルーム-ユーザー-中間テーブルから、既読チャットテキストIDを取得
        $chat_room__user = ChatRoom__User::where('chat_room_id', $id)->where('user_id', Auth::user()->id)->first();
        $newest_read_chat_text_id = $chat_room__user->newest_read_chat_text_id;
        
        // 未読のチャットテキストのみを取得
        $chat_room = ChatRoom::whereNull('deleted_at')
            ->with(['chat_texts' => function ($query) use ($newest_read_chat_text_id) {
                $query->where('id', '>', $newest_read_chat_text_id);
            }])
            ->find($id);

        // 未読がないとき
        if (empty($chat_room->chat_texts->last())) {
            //10秒待機
            sleep(10);
            // 未読のチャットテキストのみを取得
            $chat_room = ChatRoom::whereNull('deleted_at')
            ->with(['chat_texts' => function ($query) use ($newest_read_chat_text_id) {
                $query->where('id', '>', $newest_read_chat_text_id);
            }])
            ->find($id);
        }
            
        // 未読があるとき
        if (!empty($chat_room->chat_texts->last())) {
            $newest_read_chat_text_id = $chat_room->chat_texts->last()->id;

            // チャットルーム-ユーザー-中間テーブルに、既読チャットテキストIDを保存
            $now = Carbon::now();

            $chat_room__user->newest_read_chat_text_id = $newest_read_chat_text_id;
            $chat_room__user->update_user_id = Auth::user()->id;
            $chat_room__user->updated_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
            $chat_room__user->save();
        }
        
        return response()->json($chat_room);
    }

    /**
     * 入力されたチャットをDBに保存
     *
     * @param  Request  $request
     * @param チャットルームテーブルのID $id
     * @return json $chat_room
     */
    public function storeChatJson(Request $request, $id)
    {
        // 入力された文字数
        $chat_text_length = mb_strlen($request->input('chat_text'));

        if ($chat_text_length == 0) {// 空入力のとき
            return response()->json(['error' => 'メッセージが入力されていません。']);

        } else if ($chat_text_length > 500) {// 文字数が500字を超えるとき
            return response()->json(['error' => 'メッセージは500字以内で入力してください。']);
        } else {
            $now = Carbon::now();

            $chat_text = new ChatText();
            $chat_text->chat_text = $request->input('chat_text');
            $chat_text->chat_room_id = $id;
            $chat_text->user_id = Auth::user()->id;
            $chat_text->create_user_id = Auth::user()->id;
            $chat_text->update_user_id = Auth::user()->id;
            $chat_text->created_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
            $chat_text->updated_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
            $chat_text->save();
        }
        
        return response()->json(['success' => '送信が完了しました。']);
    }
}
