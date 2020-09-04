<?php

namespace App\Domain\Models;

use App\Infrastructure\Traits\UserMust;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DepoItemInfo extends Model
{
    use SoftDeletes;
    use UserMust;

    protected $table = 'depo_item_info';
    protected $primaryKey = 'depo_item_info_id';

    // ホワイトリスト
    // protected $fillable = [''];
    // ブラックリスト
    protected $guarded = [''];
}
