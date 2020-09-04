<?php

namespace App\Domain\Models;

use App\Infrastructure\Traits\UserMust;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ItemCategoryLarge extends Model
{
    use SoftDeletes;
    use UserMust;

    protected $table = 'item_category_large';
    protected $primaryKey = 'category_large_id';

    // ホワイトリスト
    // protected $fillable = [''];
    // ブラックリスト
    protected $guarded = [''];
}
