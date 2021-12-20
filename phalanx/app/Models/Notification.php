<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    // --------------- リレーション ------------------------
    
    public function notification__user() {
        return $this->hasMany(Notification__User::class);
    }

    // 終日の場合その日付を返す。それ以外の場合nullを返す
    public function date_if_allday() {
        if (!$this->is_all_day) {
            return null;
        } else {
            return (new Carbon($this->start_at))->format('Y-m-d');
        }
    }

    //-- 終日でない場合日時をフルで返す。終日の場合その日付を返す。
    public function start_date_format() {
        if (!$this->is_all_day) {
            return $this->start_at;
        } else {
            return (new Carbon($this->start_at))->format('Y-m-d');
        }
    }

    public function end_date_format() {
        if (!$this->is_all_day) {
            return $this->end_at;
        } else {
            return (new Carbon($this->end_at))->format('Y-m-d');
        }
    }
}
