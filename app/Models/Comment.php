<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function report() {
        // Mendefinisikan bahwa Comment memiliki satu Report
        return $this->belongsTo(Report::class);
    }

    public function user() {
        // Mendefinisikan bahwa Comment memiliki satu User
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'report_id', 'user_id', 'comment'
    ];
}
