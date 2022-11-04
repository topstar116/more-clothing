<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'last_name_kana',
        'first_name_kana',
        'password',
        'api_token',
        'email',
        'phone_number',
        'postcode',
        'city',
        'block',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * ユーザー一覧を取得
     *
     * @param [array] $params
     * @return App\Models\User
     */
    public function userList()
    {
        return $this->whereNull('deleted_at')->get();
    }

    /**
     * メールに一致するユーザーを抽出
     *
     * @param $email
     *
     * @return mixed
     */
    public static function findByEmail($email)
    {
        return self::query()
            ->where('email', '=', $email)
            ->whereNull('deleted_at')
            ->first();
    }

    public static function findById($user_id)
    {
        return self::query()
            ->where('id', '=', $user_id)
            ->whereNull('deleted_at')
            ->first();
    }
}