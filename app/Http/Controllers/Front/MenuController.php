<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Post;

class MenuController extends Controller
{
    public function getAboutUs(){
        return Inertia::render('Front/AboutUs/AboutUs');
    }
    public function getMentorship(){
        return Inertia::render('Front/Mentorship/Mentorship');
    }
    public function getOpportunities(){
        return Inertia::render('Front/Opportunities/Opportunities');
    }
    public function getBlog(){
        $blogPostItemId = Category::where('code', 'BLOG_ITEM')->value('id');
        $blogCoverId = Category::where('code', 'MENU_BLOG_COVER')->value('id');
        $blogs = Post::getPaginatePostByCategory($blogPostItemId, 10);
        $blogCover = Post::getFirstPostByCategory($blogCoverId);
        return Inertia::render(
            'Front/Blog/Blog',
            [
                'blogs' => $blogs,
                'blogCover' => $blogCover
            ]
        );
    }
}
