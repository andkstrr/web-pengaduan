<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public function user() {
        // Mendefinisikan bahwa setiap Report itu dimiliki oleh satu User
        return $this->belongsTo(User::class);
    }

    public function responses() {
        // Mendefinisikan bahwa Report dapat memiliki banyak Response
        return $this->hasOne(Response::class, 'report_id');
    }

    public function comments() {
        // Mendefinisikan bahwa Report dapat memiliki banyak Comment
        return $this->hasMany(Comment::class);
    }

    // Menambahkan properti yang bisa diisi (fillable)
    protected $fillable = [
        'user_id',        // ID pengguna
        'description',    // Deskripsi keluhan
        'type',           // Jenis keluhan (KEJAHATAN, PEMBANGUNAN, SOSIAL)
        'province',       // Provinsi
        'regency',        // Kota/Kabupaten
        'subdistrict',    // Kecamatan
        'village',        // Kelurahan
        'voting',         // jumlah voting
        'viewers',        // Jumlah viewers
        'image',          // Path atau nama file gambar
        'statement'       // Checkbox
    ];
}
