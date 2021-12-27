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

    private static $week_ja = ["日", "月", "火", "水", "木", "金", "土"];

    // --------------- リレーション ------------------------
    
    public function notification__user() {
        return $this->hasMany(Notification__User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'notification__user');
    }

    public function notification__office() {
        return $this->hasMany(Notification__Office::class);
    }

    public function offices()
    {
        return $this->belongsToMany(Office::class, 'notification__office');
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
        $car = new Carbon($this->start_at);
        if (!$this->is_all_day) {
            return $car->format('Y/m/d') . "(" . self::$week_ja[(int)$car->format('w')] . ") " . $car->format('H:i');
        } else {
            return $car->format('Y/m/d') . "(" . self::$week_ja[(int)$car->format('w')] . ")";
        }
    }

    public function end_date_format() {
        $car = new Carbon($this->end_at);
        if (!$this->is_all_day) {
            return $car->format('Y/m/d') . "(" . self::$week_ja[(int)$car->format('w')] . ") " . $car->format('H:i');
        } else {
            return $car->format('Y/m/d') . "(" . self::$week_ja[(int)$car->format('w')] . ")";
        }
    }

    //-- 適切なフォーマットにする。主にユーザーページ用。
    public function full_date_format() {
        $str = "";
        $format_start = "Y/n/j(@) H:i";
        $format_end = "Y/n/j(@) H:i";
        $connect = " ～ ";
        $st = new Carbon($this->start_at);
        $en = new Carbon($this->end_at);

        if( $st->isCurrentYear() ) $format_start = str_replace("Y/", "", $format_start);
        if( $en->isCurrentYear() ) $format_end = str_replace("Y/", "", $format_end);
        if( $st == $en ) $format_end = "";
        else if( $st->isSameDay($en) ) {
            $format_end = str_replace("n/j(@)", "", $format_end);
        }
        if ($this->is_all_day) {
            $format_start = str_replace("H:i", "", $format_start);
            $format_end = str_replace("H:i", "", $format_end);
            if( $st->isSameDay($en) ) $connect = "";
        }
        $format_start = trim($format_start);
        $format_end = trim($format_end);

        $str = $st->format($format_start) . $connect . $en->format($format_end);
        $str = preg_replace("/@/", self::$week_ja[(int)$st->format('w')], $str, 1);
        $str = preg_replace("/@/", self::$week_ja[(int)$en->format('w')], $str, 1);
        return $str;
    }

}
