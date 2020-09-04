<?php

namespace App\Domain\Models;

use App\Infrastructure\Traits\UserMust;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class IrregularArea extends Model
{
    use SoftDeletes;
    use UserMust;

    protected $table = 'irregular_area';
    protected $primaryKey = 'irregular_area_id';

    // ホワイトリスト　
    // protected $fillable = [''];
    // ブラックリスト
    protected $guarded = [''];
}
