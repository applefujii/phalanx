<?php
/**
 * 体験・見学申込テーブルのモデル
 * 
 * @author Fumio Mochizuki
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrialApplication extends Model
{
    use HasFactory;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'trial_applications';

    /**
     * モデルのタイムスタンプを更新するかの指示
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 関連する事業所マスタの内容を取得
     */
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
