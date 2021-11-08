<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
