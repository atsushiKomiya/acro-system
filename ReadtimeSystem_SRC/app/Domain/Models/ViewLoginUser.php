<?php

namespace App\Domain\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ViewLoginUser extends Authenticatable
{
    use Notifiable;
    protected $table = 'view_login_user';
    protected $primaryKey = 'view_login_user_id';

    // ホワイトリスト
    protected $fillable = [''];
    // ブラックリスト
    // protected $guarded = [''];

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->pass;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pass',
    ];
}
