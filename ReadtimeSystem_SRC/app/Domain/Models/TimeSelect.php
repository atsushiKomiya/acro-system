<?php

namespace App\Domain\Models;

use App\Infrastructure\Traits\UserMust;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TimeSelect extends Model
{
    use SoftDeletes;
    use UserMust;

    protected $table = 'time_select';
    protected $primaryKey = 'undeliv_type';
    public $incrementing = false;

    // ホワイトリスト
    // protected $fillable = [''];
    // ブラックリスト
    protected $guarded = [''];
}
