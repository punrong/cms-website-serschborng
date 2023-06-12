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
        $aboutUsCoverCategoryId = Category::where('code', 'MENU_ABOUT_US_COVER')->value('id');
        $aboutUsCover = Post::getFirstPostByCategory($aboutUsCoverCategoryId);

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
        $opportunitiesCoverCategoryId = Category::where('code', 'OPPORTUNITIES_MENU_COVER')->value('id');
        $opportunitiesCover = Post::getFirstPostByCategory($opportunitiesCoverCategoryId);

        $opportunitiesCategoryId = Category::where('code', 'OPPORTUNITIES_TITLE')->value('id');
        $opportunitiesPageTitle = Post::getFirstPostByCategory($opportunitiesCategoryId);

        $opportunitiesCategoryId = Category::where('code', 'OPPORTUNITIES_ITEM')->value('id');
        $opportunities = Post::getPaginatePostByCategory($opportunitiesCategoryId, 6);

        return Inertia::render('Front/Opportunities/Index', [
            'opportunitiesCover' => $opportunitiesCover,
            'opportunities' => $opportunities,
            'opportunitiesPageTitle' => $opportunitiesPageTitle
        ]);
    }
    public function getBlog()
    {
        $blogCoverCategoryId = Category::where('code', 'MENU_BLOG_COVER')->value('id');
        $blogCover = Post::getFirstPostByCategory($blogCoverCategoryId);

        $blogPageTitleCategoryId = Category::where('code', 'BLOG_TITLE')->value('id');
        $blogPageTitle = Post::getFirstPostByCategory($blogPageTitleCategoryId);

        $blogPostItemId = Category::where('code', 'BLOG_ITEM')->value('id');
        $blogs = Post::getPaginatePostByCategory($blogPostItemId, 6);
        
        return Inertia::render(
            'Front/Blog/Index',
            [
                'blogs' => $blogs,
                'blogCover' => $blogCover,
                'blogPageTitle' => $blogPageTitle
            ]
        );
    }
}
