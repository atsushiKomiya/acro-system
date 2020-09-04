<?php

namespace App\Domain\Models;

use App\Infrastructure\Traits\UserMust;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class LeadtimeDisplayGroup extends Model
{
    use SoftDeletes;
    use UserMust;

    protected $table = 'leadtime_display_group';
    protected $primaryKey = 'display_group_id';

    // ホワイトリスト
    // protected $fillable = [''];
    // ブラックリスト
    protected $guarded = [''];
}
