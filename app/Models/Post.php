<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PostHasMentors;
use App\Models\Mentor;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public static function getPostMentorIdList($postId)
    {
        return PostHasMentors::where('post_id', $postId)->pluck('mentor_id');
    }

    public static function getPostMentors($postId)
    {
        $permissionIdList = Post::getPostMentorIdList($postId);
        $permissionNameList = Mentor::whereIn('id', $permissionIdList)->where('status', 'ACT')->pluck('name')->toArray();
        if ($permissionNameList)
            return implode(', ', $permissionNameList);
        return;
    }

    public static function assignPostMentors($postId, $mentorIdList = null)
    {
        $existingPostMentor = PostHasMentors::where('post_id', $postId);
        if (count($existingPostMentor->get()) > 0)
            $existingPostMentor->delete();
        $postMentorRecords = [];
        if (isset($mentorIdList)) {
            foreach ($mentorIdList as $mentorId)
                $postMentorRecords[] = [
                    'mentor_id' => $mentorId,
                    'post_id' => $postId,
                    'created_by' => Auth::user()->id
                ];
            if (PostHasMentors::insert($postMentorRecords));
            return true;
            return false;
        } else
            return true;
    }

    public static function getFirstPostByCategory($category_id)
    {
        $post = Post::where('category_id', $category_id)->where('status', 'ACT')->first();
        $post->image = $post->image ? asset($post->image) : null;
        return $post;
    }

    public static function getTopThreePostByCategory($category_id)
    {
        $posts = Post::where('category_id', $category_id)->where('status', 'ACT')->orderBy('sequence')->take(3)->get();
        foreach ($posts as $post) {
            $post->image = $post->image ? asset($post->image) : null;
        }
        return $posts;
    }

    public static function getAllPostByCategory($category_id)
    {
        $posts = Post::where('category_id', $category_id)->where('status', 'ACT')->orderBy('sequence')->get();
        foreach ($posts as $post) {
            $post->image = $post->image ? asset($post->image) : null;
        }
        return $posts;
    }
    public static function getPaginatePostByCategory($category_id, $paginate_number)
    {
        $posts = Post::where('category_id', $category_id)->where('status', 'ACT')->orderBy('sequence')->paginate($paginate_number);
        foreach ($posts as $post) {
            $post->image = $post->image ? asset($post->image) : null;
        }
        return $posts;
    }
}
