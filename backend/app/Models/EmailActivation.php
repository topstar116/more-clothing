<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class EmailActivation extends Model
{
    use HasFactory;

    const EXPIRATION_HOURS = 1;   // 有効期限のデフォルト(時間)

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'token',
        'ttl',
        'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'url_token',
    ];

    /**
     * 日付を変形する属性
     *
     * @var array
     */
    protected $dates = [
        'ttl',
    ];

    /**
     * 仮会員登録
     *
     * @param $email
     * @param int $hours
     *
     * @return EmailVerification
     */
    public static function build($email, $type = 0, $hours = self::EXPIRATION_HOURS)
    {
        $date = now();

        return new self([
            'email'      => $email,
            'token'  => md5(uniqid(rand(), true)) . $date->getTimestamp(),
            'ttl' => Carbon::now()->addHours($hours),
            'type' => $type,
        ]);
    }

    /**
     * トークンに一致するデータを抽出
     *
     * @param $token
     *
     * @return mixed
     */
    public static function findByToken($token)
    {
        return self::query()
            ->where('token', '=', $token)
            ->first();
    }

    /**
     * 有効期限内かどうかを取得
     *
     * @return bool
     */
    public function isExpiration()
    {
        return $this->ttl >= Carbon::now();
    }

    public static function findByEmail($email) {
        return self::query()
            ->where('email', $email)
            ->first();
    }

    public static function deleteByEmail($email) {
        return self::query()
            ->where('email', $email)
            ->where('type', 1)
            ->delete();
    }
}