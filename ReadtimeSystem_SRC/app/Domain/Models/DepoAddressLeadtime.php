<?php

namespace App\Domain\Models;

use App\Infrastructure\Traits\UserMust;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DepoAddressLeadtime extends Model
{
    use SoftDeletes;
    use UserMust;
    protected $table = 'depo_address_leadtime';
    protected $primaryKey = 'depo_address_leadtime_id';

    // ホワイトリスト
    // protected $fillable = [''];
    // ブラックリスト
    protected $guarded = [''];
}
