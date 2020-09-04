<?php

namespace App\Infrastructure\Traits;

use Illuminate\Support\Facades\Auth;

trait UserMust
{
    public static function bootUserMust()
    {
        /**
         * save（create）時に認証情報より自動的に作成者ID、更新者IDを付与する
         */
        static::creating(function ($model) {
            $user = Auth::user();
            if ($user) {
                $model->created_id = $user->login_cd;
                $model->updated_id = $user->login_cd;
            }
        });

        /**
         * save（update）時に認証情報より自動的に作成者ID、更新者IDを付与する
         */
        static::updating(function ($model) {
            $user = Auth::user();
            if ($user) {
                $model->updated_id = $user->login_cd;
            }
        });

        /**
         * delete時に認証情報より自動的に更新者ID、削除者IDを付与する
         */
        static::deleting(function ($model) {
            $user = Auth::user();
            if ($user) {
                $model->updated_id = $user->login_cd;
                $model->deleted_id = $user->login_cd;
            }
        });

        /**
         * restore時に認証情報より自動的に更新者IDを付与する
         */
        static::restoring(function ($model) {
            $user = Auth::user();
            if ($user) {
                $model->updated_id = $user->login_cd;
            }
        });
    }
}
