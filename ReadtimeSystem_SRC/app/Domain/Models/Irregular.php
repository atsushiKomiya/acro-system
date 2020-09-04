<?php

namespace App\Domain\Models;

use App\Infrastructure\Traits\UserMust;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Irregular extends Model
{
    use SoftDeletes;
    use UserMust;

    protected $table = 'irregular';
    protected $primaryKey = 'irregular_id';

    // ホワイトリスト
    // protected $fillable = [''];
    // ブラックリスト
    protected $guarded = [''];
}
