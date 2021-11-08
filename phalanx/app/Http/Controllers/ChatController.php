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
        $chat_room = ChatRoom::whereNull('deleted_at')->findOrFail($id);
        $chat_texts = $chat_room->chat_texts()->orderBy('created_at')->get();
        
        return view('chat/index', compact('chat_room', 'chat_texts'));
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
}
