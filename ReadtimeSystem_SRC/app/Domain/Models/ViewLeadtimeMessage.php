<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class ViewLeadtimeMessage extends Model
{
    protected $table = 'view_leadtime_message';
    protected $primaryKey = null;
    public $incrementing = false;

    // ホワイトリスト
    protected $fillable = [''];
    // ブラックリスト
    // protected $guarded = [''];
}
