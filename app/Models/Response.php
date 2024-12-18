<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    public function report() {
        // Mendefinisikan bahwa Response memiliki satu Report
        return $this->belongsTo(Report::class, 'report_id');
    }
}
