<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'response_id',
        'histories',
    ];

    // Cast agar berubah menjadi array (json)
    protected $casts = [
        'histories' => 'array',
    ];
}
