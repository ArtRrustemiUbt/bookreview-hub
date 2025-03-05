<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class AdminNotification extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'notifications';

    protected $fillable = ['type', 'message', 'data', 'is_read', 'created_at'];
}
