<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
class Notice extends Model
{
    use SoftDeletes;

    //
    protected $fillable = ['content','merchant','member','modal'];
    protected $dates = ['deleted_at'];
}
