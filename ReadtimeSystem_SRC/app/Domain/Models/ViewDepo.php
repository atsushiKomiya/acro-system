<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class ViewDepo extends Model
{
    protected $table = 'view_depo';
    protected $primaryKey = null;
    public $incrementing = false;

    // ホワイトリスト
    protected $fillable = [''];
    // ブラックリスト
    // protected $guarded = [''];
}
