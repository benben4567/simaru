<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'activity_log';
    protected $fillable = ['level', 'url', 'method', 'ip', 'agent', 'subject', 'subject_id', 'causer_id', 'description'];
}
