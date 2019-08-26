<?php

namespace App\Models;


class LoginLog extends Model
{
    protected $table = "login_logs";

    protected $fillable = ['role','uid', 'name', 'action', 'ip', 'locate', 'user_agent'];
}
