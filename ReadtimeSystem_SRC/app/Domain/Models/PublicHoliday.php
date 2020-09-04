<?php

namespace App\Domain\Models;

use App\Infrastructure\Traits\UserMust;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PublicHoliday extends Model
{
    use SoftDeletes;
    use UserMust;

    protected $table = 'public_holiday';
    protected $primaryKey = 'date';
    public $incrementing = false;

    // ホワイトリスト
    // protected $fillable = [''];
    // ブラックリスト
    protected $guarded = [''];
}
