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
        'created_by',
        'updated_by'
    ];

    public static function getMentorList(){
        return Mentor::select( 'name', 'id as value')->where('status', 'ACT')->orderBy('id', 'asc')->get();
    }

    public static function getPaginateMentorList($paginate_number){
        $mentors = Mentor::where('status', 'ACT')->paginate($paginate_number);
        foreach ($mentors as $mentor) {
            $mentor->image = $mentor->image ? asset($mentor->image) : null;
        }
        return $mentors;
    }
}
