<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Post;

class MenuController extends Controller
{
    public function getAboutUs()
    {
        $aboutUsCoverId = Category::where('code', 'MENU_ABOUT_US_COVER')->value('id');
        $aboutUsCover = Post::getFirstPostByCategory($aboutUsCoverId);
        $ourFounderCategoryId = Category::where('code', 'ABOUT_US_OUR_FOUNDER')->value('id');
        $ourFounder = Post::getFirstPostByCategory($ourFounderCategoryId);
        $ourStoryCategoryId = Category::where('code', 'ABOUT_US_OUR_STORY')->value('id');
        $ourStory = Post::getFirstPostByCategory($ourStoryCategoryId);
        return Inertia::render(
            'Front/AboutUs/Index',
            [
                'aboutUsCover' => $aboutUsCover,
                'ourFounder' => $ourFounder,
                'ourStory' => $ourStory,
            ]
        );
    }
    public function getMentorship()
    {
        return Inertia::render('Front/Mentorship/Index');
    }
    public function getOpportunities()
    {
        return Inertia::render('Front/Opportunities/Index');
    }
    public function getBlog()
    {
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
