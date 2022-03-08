<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'scores';

    /**
     * モデルのタイムスタンプを更新するかの指示
     *
     * @var bool
     */

    public $timestamps = false;


    /**
     * リレーション
     *
     * 事業所
     */
    public function office() {
        return $this->belongsTo(Office::class);
    }
}
