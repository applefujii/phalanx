<?php

/**
 * チャットルーム-ユーザー中間テーブルのモデル
 * 
 * @author Kakeru Kusada
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat_room__User extends Model
{
    use HasFactory;

    /**
     * モデルと関連しているテーブル
     * 
     * @var string
     */
    protected $table = "chat_room__user";

    /**
     * タイムスタンプを更新するかどうかの指示
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * 関連するチャットルームのデータの取得
     */
    public function chat_room() {
        return $this->belongsTo(Chat_room::class);
    }

    /**
     * 関連するユーザーマスタのデータの取得
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * 関連するチャットテキストのデータの取得
     */
    public function chat_text() {
        return $this->belongsTo(Chat_text::class);
    }
}
