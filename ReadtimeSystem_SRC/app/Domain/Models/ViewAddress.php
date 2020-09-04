<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class ViewAddress extends Model
{
    protected $table = 'view_address';
    protected $primaryKey = null;
    public $incrementing = false;

    // ホワイトリスト
    protected $fillable = [''];
    // ブラックリスト
    // protected $guarded = [''];
}
