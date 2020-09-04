<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class ViewShain extends Model
{
    protected $table = 'view_shain';
    protected $primaryKey = null;
    public $incrementing = false;

    // ホワイトリスト
    protected $fillable = [''];
    // ブラックリスト
    // protected $guarded = [''];
}
