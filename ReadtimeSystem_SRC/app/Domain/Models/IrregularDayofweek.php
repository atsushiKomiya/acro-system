<?php

namespace App\Domain\Models;

use App\Infrastructure\Traits\UserMust;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class IrregularDayofweek extends Model
{
    use SoftDeletes;
    use UserMust;

    protected $table = 'irregular_dayofweek';
    protected $primaryKey = 'irregular_dayofweek_id';

    // ホワイトリスト　
    // protected $fillable = [''];
    // ブラックリスト
    protected $guarded = [''];
}
