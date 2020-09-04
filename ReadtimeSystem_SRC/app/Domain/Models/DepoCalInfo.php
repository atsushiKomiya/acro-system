<?php

namespace App\Domain\Models;

use App\Infrastructure\Traits\UserMust;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DepoCalInfo extends Model
{
    use SoftDeletes;
    use UserMust;

    protected $table = 'depo_cal_info';
    protected $primaryKey = 'depo_cal_id';

    // ホワイトリスト
    // protected $fillable = [''];
    // ブラックリスト
    protected $guarded = [''];
}
