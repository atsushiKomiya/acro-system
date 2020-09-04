<?php

namespace App\Domain\Models;

use App\Infrastructure\Traits\UserMust;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ItemCategoryRelation extends Model
{
    use SoftDeletes;
    use UserMust;

    protected $table = 'item_category_relation';
    protected $primaryKey = 'item_category_relation_id';

    // ホワイトリスト
    // protected $fillable = [''];
    // ブラックリスト
    protected $guarded = [''];
}
