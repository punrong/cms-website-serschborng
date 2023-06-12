<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class PostHasMentors extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'post_id',
        'mentor_id',
        'created_by',
    ];

    public static function getMentorListByOpportunity($postId){
        $mentorIdList = Post::getPostMentorIdList($postId);
        $mentorList = Mentor::whereIn('id', $mentorIdList)->where('status', 'ACT')->get();
        foreach ($mentorList as $mentor) {
            $mentor->image = $mentor->image ? asset($mentor->image) : null;
        }
        return $mentorList;
    }
}
