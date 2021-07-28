<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RequestDetail;

class Tool extends Model
{
    use HasFactory;
    protected $fillable =['quanity'];
    
    public function requests()
    {
        return $this->belongsToMany(Requests::class, 'request_tool', 'user_request_id', 'tool_id');
    }
}
