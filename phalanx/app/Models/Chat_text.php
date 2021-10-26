<?php

/**
 * チャットテキストテーブルのモデル
 * 
 * @author Kakeru Kusada
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat_text extends Model
{
    use HasFactory;

    /**
     * モデルと関連しているテーブル
     * 
     * @var string
     */
    protected $table = "chat_texts";

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
     * 関連するチャットルーム-ユーザー中間テーブルのデータの取得
     */
    public function chat_room__user() {
        return $this->hasMany(Chat_room__User::class);
    }
}