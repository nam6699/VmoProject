<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RequestDetail extends Model
{
    use HasFactory;
    protected $table = "request_detail";
    public $timestamps = false;

    public function requests()
    {
        return $this->belongsTo(Requests::class,'user_requests_id', 'id');
    }
   
}
