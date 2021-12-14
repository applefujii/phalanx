<?php

/**
 * チャットテキストテーブルのモデル
 * 
 * @author Kakeru Kusada
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatText extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

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
     * 常にロードする必要があるリレーション
     *
     * @var array
     */
    protected $with = ['user'];

    /**
     * 関連するチャットルームのデータの取得
     */
    public function chat_room() {
        return $this->belongsTo(ChatRoom::class)->whereNull('deleted_at');
    }

    /**
     * 関連するユーザーマスタのデータの取得
     */
    public function user() {
        return $this->belongsTo(User::class)->whereNull('deleted_at');
    }

    /**
     * 関連するチャットルーム-ユーザー中間テーブルのデータの取得
     */
    public function chat_room__user() {
        return $this->hasMany(ChatRoom__User::class);
    }
}
