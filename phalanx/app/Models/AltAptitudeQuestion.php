<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AltAptitudeQuestion extends Model
{
    use HasFactory;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'alt_aptitude_questions';

    /**
     * モデルのタイムスタンプを更新するかの指示
     *
     * @var bool
     */
    
    public $timestamps = false;
}
