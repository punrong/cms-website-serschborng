<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostHasMentors extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'post_id',
        'mentor_id',
    ];
}
