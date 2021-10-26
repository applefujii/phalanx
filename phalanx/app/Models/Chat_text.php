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
    public function chat_rooms() {
        return $this->belongsTo(Chat_room::class);
    }

    /**
     * 関連するユーザーマスタのデータの取得
     */
    public function users() {
        return $this->belongsTo(User::class);
    }
}
