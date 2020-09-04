<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CUse extends Model
{
    use SoftDeletes;
    protected $table = 'c_use';
    protected $primaryKey = 'c_use';
    public $incrementing = false;

    // ホワイトリスト
    // protected $fillable = [''];
    // ブラックリスト
    protected $guarded = [''];
}
