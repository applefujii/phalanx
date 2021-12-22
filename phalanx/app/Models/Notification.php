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
}
