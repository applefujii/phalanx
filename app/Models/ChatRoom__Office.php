<?php
/**
 * チャットルーム-事業所中間テーブルのモデル
 * 
 * @author Fumio Mochizuki
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom__Office extends Model
{
    use HasFactory;

    /**
     * モデルと関連しているテーブル
     * 
     * @var string
     */
    protected $table = "chat_room__office";

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
        return $this->belongsTo(ChatRoom::class);
    }

    /**
     * 関連する事業所マスタのデータの取得
     */
    public function office() {
        return $this->belongsTo(Office::class);
    }
}
