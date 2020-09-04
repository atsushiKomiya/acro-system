<?php

namespace App\Domain\Models;

use App\Infrastructure\Traits\UserMust;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DepoCalAprInfo extends Model
{
    use SoftDeletes;
    use UserMust;

    protected $table = 'depo_cal_apr_info';
    protected $primaryKey = 'depo_cal_apr_id';

    // ホワイトリスト
    // protected $fillable = [''];
    // ブラックリスト
    protected $guarded = [''];
}
