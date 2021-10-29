<?php
/**
 * 適性診断質問テーブルのモデル
 * 
 * @author Fumio Mochizuki
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AptitudeQuestion extends Model
{
    use HasFactory;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'aptitude_questions';

    /**
     * モデルのタイムスタンプを更新するかの指示
     *
     * @var bool
     */
    
    public $timestamps = false;
}
