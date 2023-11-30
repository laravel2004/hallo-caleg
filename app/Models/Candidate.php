<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model {
    use HasFactory;

    protected $fillable = [
        'partai',
        'name',
        'nomor_urut',
        'image',
        'jenis_kelamin',
        'tempat_tinggal',
    ];

    public function quickcount() {
        return $this->hasMany(Quickcount::class, 'candidate_id', 'id');
    }
}
