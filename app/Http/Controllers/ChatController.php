<?php

/**
 * チャット画面用のコントローラ
 * 
 * @author Fumio Mochizuki
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChatTextRequest;
use App\Models\Chat_room;
use App\Models\Chat_room__User;
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
        $chat_texts = Chat_room::whereNull('deleted_at')->findOrFail($id)->chat_texts()->orderBy('created_at')->get();
        
        return view('chat/index', compact('chat_texts'));
    }

    /**
     * チャット文章をDBに保存
     *
     * @param  \App\Http\Requests\ChatTextRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChatTextRequest $request, $id)
    {
        $now = Carbon::now();
        $desired_date = new Carbon($request->input('desired_date'));

        $trial_application = new TrialApplication();
        $trial_application->name = Crypt::encryptString($request->input('name'));
        $trial_application->name_kana = Crypt::encryptString($request->input('name_kana'));
        $trial_application->office_id = $request->input('office_id');
        $trial_application->desired_date = $request->input('desired_date');
        $trial_application->email = Crypt::encryptString($request->input('email'));
        $trial_application->phone_number = Crypt::encryptString($request->input('phone_number'));
        $trial_application->created_at = $now->isoFormat('YYYY-MM-DD');
        $trial_application->updated_at = $now->isoFormat('YYYY-MM-DD');
        $trial_application->save();

        return redirect()->route('chat.index', $id);
    }
}
