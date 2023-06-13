<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Mentor;
use App\Models\Post;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'mentee_id',
        'mentor_id',
        'opportunity_id',
        'method',
        'appointment_datetime',
        'status',
        'description',
        'created_by',
        'updated_by'
    ];

    public function mentee()
    {
        return $this->belongsTo(User::class);
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

    public function opportunity()
    {
        return $this->belongsTo(Post::class);
    }
}
