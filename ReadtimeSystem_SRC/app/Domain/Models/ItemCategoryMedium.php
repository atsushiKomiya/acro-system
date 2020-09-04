<?php

namespace App\Domain\Models;

use App\Infrastructure\Traits\UserMust;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ItemCategoryMedium extends Model
{
    use SoftDeletes;
    use UserMust;

    protected $table = 'item_category_medium';
    protected $primaryKey = 'category_medium_id';

    // ホワイトリスト
    // protected $fillable = [''];
    // ブラックリスト
    protected $guarded = [''];
}
