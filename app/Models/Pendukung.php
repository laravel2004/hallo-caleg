<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendukung extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'usia',
        'kec',
        'desa',
        'rt',
        'rw',
        'tps_id',
        'user_id',
    ];

    public function tps() {
        return $this->belongsTo(Tps::class, 'tps_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
