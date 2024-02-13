<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quickcount extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'total',
        'tps_id'
    ];

    public function candidate() {
        return $this->belongsTo(Candidate::class, 'candidate_id', 'id');
    }

    public function tps() {
        return $this->belongsTo(Tps::class, 'tps_id', 'id');
    }
}
