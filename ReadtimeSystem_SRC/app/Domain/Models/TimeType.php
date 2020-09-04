<?php

namespace App\Domain\Models;

use App\Infrastructure\Traits\UserMust;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TimeType extends Model
{
    use SoftDeletes;
    use UserMust;

    protected $table = 'time_type';
    protected $primaryKey = 'time_type_id';

    // ホワイトリスト
    // protected $fillable = [''];
    // ブラックリスト
    protected $guarded = [''];
}
