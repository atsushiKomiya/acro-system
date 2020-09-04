<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class ViewItem extends Model
{
    protected $table = 'view_item';
    protected $primaryKey = null;
    public $incrementing = false;

    // ホワイトリスト
    protected $fillable = [''];
    // ブラックリスト
    // protected $guarded = [''];
}
