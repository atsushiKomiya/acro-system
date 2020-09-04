<?php

namespace App\Domain\Models;

use App\Infrastructure\Traits\UserMust;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class IrregularItem extends Model
{
    use SoftDeletes;
    use UserMust;

    protected $table = 'irregular_item';
    protected $primaryKey = 'irregular_item_id';

    // ホワイトリスト　
    // protected $fillable = [''];
    // ブラックリスト
    protected $guarded = [''];
}
