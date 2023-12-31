<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quickcount extends Model
{
    use HasFactory;

    public function candidate() {
        return $this->belongsTo(Candidate::class, 'candidate_id', 'id');
    }
}
