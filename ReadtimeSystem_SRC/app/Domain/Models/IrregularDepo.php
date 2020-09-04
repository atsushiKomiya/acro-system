<?php

namespace App\Domain\Models;

use App\Infrastructure\Traits\UserMust;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class IrregularDepo extends Model
{
    use SoftDeletes;
    use UserMust;

    protected $table = 'irregular_depo';
    protected $primaryKey = 'irregular_depo_id';

    // ホワイトリスト
    // protected $fillable = [''];
    // ブラックリスト
    protected $guarded = [''];
}
