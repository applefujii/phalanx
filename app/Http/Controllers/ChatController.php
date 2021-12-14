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
use App\Models\UserType;
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

            //未読があるチャットルームのidを取得
            $unreadId = [];
            $cuFinds = ChatRoom__User::where("user_id", $user->id)->get();
            foreach($cuFinds as $cuFind) {
                $ctFind = ChatText::whereNull("deleted_at")->where("chat_room_id", $cuFind->chat_room_id)->where("user_id", "<>", $user->id)
                    ->orderBy("id", "desc")->first();
                if(isset($ctFind) && $cuFind->newest_read_chat_text_id < $ctFind->id) {
                    $unreadId[] = $cuFind->chat_room_id;
                }
            }

            // 所属しているチャットルームを取得
            $join_chat_rooms = ChatRoom::whereNull("deleted_at")
                ->with('users')
                ->whereHas('users', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->orderBy('distinction_number')
                ->orderBy('user_id')
                ->orderBy('id')
                ->get();

            //事業所一覧を取得
            $offices = Office::whereNull("deleted_at")->orderBy("sort")->get();

            return view("chat.index", compact('join_chat_rooms', "offices", "unreadId"));
        } else {
            //chat_roomsテーブルのuser_idが$userIdと一致するものを検索
            $chat_room = ChatRoom::where("user_id", $user->id)->first();

            return redirect()->route("chat.show", $chat_room->id);
        }
    }

    /**
     * チャット画面を表示
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //ログイン中のユーザーのidを取得
        $user = Auth::user();

        $chat_room = ChatRoom::whereNull('deleted_at')
            ->whereHas('users', function($query) use ($user) {
                //表示するチャットルームにログイン中のユーザーが参加しているかの判別
                $query->where('user_id', $user->id);
            })
            ->findOrFail($id);

        //未読があるチャットルームのidを取得
        $unreadId = [];
        $cuFinds = ChatRoom__User::where("user_id", $user->id)->get();
        foreach($cuFinds as $cuFind) {
            $ctFind = ChatText::whereNull("deleted_at")->where("chat_room_id", $cuFind->chat_room_id)->where("user_id", "<>", $user->id)
                ->orderBy("id", "desc")->first();
            if(isset($ctFind) && $cuFind->newest_read_chat_text_id < $ctFind->id) {
                $unreadId[] = $cuFind->chat_room_id;
            }
        }

        // 所属しているチャットルームを取得
        $join_chat_rooms = ChatRoom::whereNull("deleted_at")
            ->with('users')
            ->whereHas('users', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('distinction_number')
            ->orderBy('user_id')
            ->orderBy('id')
            ->get();

        //事業所一覧を取得
        $offices = Office::whereNull("deleted_at")->orderBy("sort")->get();

        // ユーザー種別一覧
        $user_types = UserType::whereNull("deleted_at")->orderBy("id")->get();

        return view('chat/show', compact('join_chat_rooms', 'chat_room', 'user_types', 'offices', "unreadId"));
    }

    /**
     * 一斉送信されたチャットをDBに保存
     * 
     * @param \App\Http\Requests\ChatTextRequest $request
     * @return \Illuminate\http\Response
     */
    public function multiStore(ChatTextRequest $request) {

        //Requestから渡されたchat_roomsを配列に変換し、データを挿入
        $chatRooms = $request->input("chat_rooms");
        $roomsId = explode(",", $chatRooms);
        DB::transaction(function () use($roomsId, $request) {
            $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');
            $aItem = [];
            foreach($roomsId as $roomId) {

                //各種データを$aItemに挿入
                array_push($aItem, [
                    "chat_text" => $request->input("chat_text"),
                    "chat_room_id" => $roomId,
                    "user_id" => Auth::id(),
                    "create_user_id" => Auth::id(),
                    "update_user_id" => Auth::id(),
                    "created_at" => $now,
                    "updated_at" => $now
                ]);
            }

            $aChunk = array_chunk($aItem, 100);
            foreach($aChunk as $chunk) {
                ChatText::insert($chunk);
            }
        });
        

        return redirect()->route("chat.index");
    }

    /**
     * チャットテキスト作成の実行部分
     * 
     * @param Request $request
     * @return int $id
     */
    public function storeDetail(Request $request) {
        
    }

    /**
     * チャットログをjavascriptで取得
     * 
     * @param チャットルームテーブルのID $chat_room_id
     * @return json $chat_room
     */
    public function getChatLogJson ($chat_room_id)
    {
        // チャットルーム-ユーザー-中間テーブルから、既読チャットテキストIDを取得
        $chat_room__user = ChatRoom__User::where('chat_room_id', $chat_room_id)->where('user_id', Auth::user()->id)->first();
        $newest_read_chat_text_id = $chat_room__user->newest_read_chat_text_id;

        // チャットテキストを取得
        $chat_room = ChatRoom::whereNull('deleted_at')
            ->with(['chat_texts' => function ($query) {
                $query->whereNull('deleted_at')->orderByDesc('id')->limit(config('const.chat_text_limit'));
            }])
            ->find($chat_room_id);
        
        //配列に変換
        $chat_room_array = $chat_room->toArray();

        // 戻り値に追加
        $chat_room_array += array(
            'newest_read_chat_text_id' => $newest_read_chat_text_id,
        );

        // 過去ログがあるとき
        if (!empty($chat_room->chat_texts->first())) {
            
            // 表示している中で最古のテキストのID
            $oldest_display_chat_text_id = $chat_room->chat_texts->last()->id;

            // 戻り値に追加
            $chat_room_array += array(
                'oldest_display_chat_text_id' => $oldest_display_chat_text_id,
            );
            
            // 既読チャットテキストID
            $newest_read_chat_text_id = $chat_room->chat_texts->first()->id;

            // チャットルーム-ユーザー-中間テーブルに、既読チャットテキストIDを保存
            $now = Carbon::now();

            $chat_room__user->newest_read_chat_text_id = $newest_read_chat_text_id;
            $chat_room__user->update_user_id = Auth::user()->id;
            $chat_room__user->updated_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
            $chat_room__user->save();
        }

        return response()->json($chat_room_array);
    }

    /**
     * チャットログの差分をjavascriptで取得
     * 
     * @param チャットルームテーブルのID $chat_room_id
     * @return json $chat_room
     */
    public function getNewChatLogJson ($chat_room_id)
    {
        // チャットルーム-ユーザー-中間テーブルから、既読チャットテキストIDを取得
        $chat_room__user = ChatRoom__User::where('chat_room_id', $chat_room_id)->where('user_id', Auth::user()->id)->first();
        $newest_read_chat_text_id = $chat_room__user->newest_read_chat_text_id;

        // 未読がなければ最大10秒間待ってから値を返す
        foreach (range(1, 10) as $value) {
            // 未読のチャットテキストのみを取得
            $chat_room = ChatRoom::whereNull('deleted_at')
            ->when($newest_read_chat_text_id, function ($query) use ($newest_read_chat_text_id) {
                $query->with(['chat_texts' => function ($query) use ($newest_read_chat_text_id) {
                    $query->where('id', '>', $newest_read_chat_text_id)->whereNull('deleted_at')->orderBy('id');
                }]);
            })
            ->find($chat_room_id);

            // 未読があるとき
            if (!empty($chat_room->chat_texts->last())) {
                break;
            }

            //1秒待機
            sleep(1);
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
     * 過去のチャットログをjavascriptで取得
     * 
     * @param チャットルームテーブルのID $chat_room_id
     * @param チャットテキストのID $chat_text_id
     * @return json $chat_room
     */
    public function getOldChatLogJson ($chat_room_id, $chat_text_id)
    {
        // $chat_text_idより古いテキストのみを取得
        $chat_room = ChatRoom::whereNull('deleted_at')
        ->with(['chat_texts' => function ($query) use ($chat_text_id) {
            $query->where('id', '<', $chat_text_id)->whereNull('deleted_at')->orderByDesc('id')->limit(config('const.chat_text_limit'));
        }])
        ->find($chat_room_id);
        
        return response()->json($chat_room);
    }

    /**
     * 入力されたチャットをDBに保存
     *
     * @param  Request  $request
     * @param チャットルームテーブルのID $id
     * @return json $chat_room
     */
    public function storeChatJson(Request $request, $chat_room_id)
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
            $chat_text->chat_room_id = $chat_room_id;
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
