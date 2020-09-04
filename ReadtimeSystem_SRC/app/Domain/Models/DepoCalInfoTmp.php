<?php

namespace App\Domain\Models;

use App\Infrastructure\Traits\UserMust;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DepoCalInfoTmp extends Model
{
    use SoftDeletes;
    use UserMust;

    protected $table = 'depo_cal_info_tmp';
    protected $primaryKey = 'depo_cal_tmp_id';
    public $incrementing = false;

    // ホワイトリスト
    // protected $fillable = [''];
    // ブラックリスト
    protected $guarded = [''];
}
