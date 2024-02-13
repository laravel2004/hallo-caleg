<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\Village;

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

    public function village() {
        return $this->belongsTo(Village::class, 'village_id', 'id');
    }
}
