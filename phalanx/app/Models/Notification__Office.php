<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification__Office extends Model
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

    // --------------- リレーション ------------------------
    
    public function notification() {
        return $this->belongsTo(Notification::class);
    }

    public function office() {
        return $this->belongsTo(Office::class);
    }
}
