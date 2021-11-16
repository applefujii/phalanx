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
     * チャット画面
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $chat_room = ChatRoom::whereNull('deleted_at')->with('chat_texts')->findOrFail($id);
        //ログイン中のユーザーのidを取得
        $user = Auth::user();

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

        return view('chat/index', compact('chat_room', "userRooms", "group", "joinRooms", "offices"));
    }

    /**
     * チャット文章をDBに保存
     *
     * @param  \App\Http\Requests\ChatTextRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChatTextRequest $request, $chat_room_id)
    {
        $now = Carbon::now();

        $chat_text = new ChatText();
        $chat_text->chat_text = $request->input('chat_text');
        $chat_text->chat_room_id = $chat_room_id;
        $chat_text->user_id = Auth::user()->id;
        $chat_text->create_user_id = Auth::user()->id;
        $chat_text->update_user_id = Auth::user()->id;
        $chat_text->created_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
        $chat_text->updated_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
        $chat_text->save();

        return redirect()->route('chat.index', $chat_room_id);
    }

    /**
     * 一斉送信されたチャットをDBに保存
     * 
     * @param \App\Http\Requests\ChatTextRequest $request
     * @return \Illuminate\http\Response
     */
    public function multiStore(ChatTextRequest $request) {
        
    }

    /**
     * チャットルームのテキストをjavascriptで取得
     * @param $chat_room_id
     * @param array $request 登録情報[id]
     * @return json 実行結果
     */
    public function getChatRoomJson ($id)
    {
        $chat_room = ChatRoom::whereNull('deleted_at')->with('chat_texts')->find($id);
        return response()->json($chat_room);
    }

    /**
     * チャット文章をDBに保存
     *
     * @param  \App\Http\Requests\ChatTextRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeJson(ChatTextRequest $request, $id)
    {
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

        $chat_room = ChatRoom::whereNull('deleted_at')->with('chat_texts')->find($id);
        
        return response()->json($chat_room);
    }
}
