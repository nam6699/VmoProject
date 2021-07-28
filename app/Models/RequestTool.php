<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestTool extends Model
{
    use HasFactory;
    protected $table = 'request_tool';
    public $timestamps = false;
}
