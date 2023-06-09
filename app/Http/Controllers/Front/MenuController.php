<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Post;

class MenuController extends Controller
{
    public function getAboutUs(){
        return Inertia::render('Front/AboutUs/Index');
    }
    public function getMentorship(){
        return Inertia::render('Front/Mentorship/Index');
    }
    public function getOpportunities(){
        return Inertia::render('Front/Opportunities/Index');
    }
    public function getBlog(){
        $blogPostItemId = Category::where('code', 'BLOG_ITEM')->value('id');
        $blogCoverId = Category::where('code', 'MENU_BLOG_COVER')->value('id');
        $blogs = Post::getPaginatePostByCategory($blogPostItemId, 6);
        $blogCover = Post::getFirstPostByCategory($blogCoverId);
        return Inertia::render(
            'Front/Blog/Index',
            [
                'blogs' => $blogs,
                'blogCover' => $blogCover
            ]
        );
    }
}
