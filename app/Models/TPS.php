<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TPS extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'alamat',
        'village_id'
    ];

    public function quickcount() {
        return $this->hasMany(QuickCount::class, 'tps_id', 'id');
    }
}
