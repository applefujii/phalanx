<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    // 仮想フィールド
    protected $appends = ['type_color'];

    // 表示色
    public function getTypeColorAttribute()
    {
        $id = $this->id;

        if ($id === 1) {
            $type_color = 'text-danger';
        } else {
            $type_color = 'text-success';
        }

        return $type_color ?? "";
    }
}
