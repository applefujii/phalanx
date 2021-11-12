<?php

/**
 * チャットルームテーブルのモデル
 * 
 * @author Kakeru Kusada
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    /**
     * モデルと関連しているテーブル
     * 
     * @var string
     */
    protected $table = "chat_rooms";

    /**
     * タイムスタンプを更新するかどうかの指示
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * 関連する事業所マスタのデータを取得
     */
    public function office() {
        return $this->belongsTo(Office::class);
    }

    /**
     * 関連するチャットルーム-ユーザーテーブルのデータを取得
     */
    public function chat_room__user() {
        return $this->hasMany(ChatRoom__User::class);
    }

    /**
     * 関連するユーザーマスタのデータを取得
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * 関連するチャットテキストのデータを取得
     */
    public function chat_texts() {
        return $this->hasMany(ChatText::class)->whereNull('deleted_at')->orderBy('created_at');
    }
}
