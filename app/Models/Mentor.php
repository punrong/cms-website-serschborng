<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'image',
        'status',
    ];

    public static function getMentorList(){
        return Mentor::select( 'name', 'id as value')->where('status', 'ACT')->orderBy('id', 'asc')->get();
    }
}
