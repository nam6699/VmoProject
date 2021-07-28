<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tool;

class Requests extends Model
{
    use HasFactory;
    protected $table = "user_requests";
    public $timestamps = false;

    public function details()
    {
        return $this->hasMany(RequestDetail::class,'user_requests_id', 'id');
    }
    public function tools()
    {
        return $this->belongsToMany(Tool::class, 'request_tool', 'user_request_id', 'tool_id');
    }
}
