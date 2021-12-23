<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'name_katakana',
        'user_type_id',
        'office_id',
        'login_name',
        'password',
        'create_user_id',
        'update_user_id',
        'delete_user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that are gureded
     * @var array
     */
    protected $guarded = [
        'user_type_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [];

    public function user_type() {
        return $this->belongsTo(UserType::class)->whereIn("id", [1, 2, 3]);
    }

    public function office() {
        return $this->belongsTo(Office::class);
    }

    public function notification__user() {
        return $this->hasMany(Notification__User::class);
    }

    // リファクタリングする機会があったら
    public function is_staff() {
        return $this->user_type_id == 1  |  $this->user_type_id == 4;
    }
}
