<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Post;
use App\Models\Mentor;

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
        $mentorshipCoverCategoryId = Category::where('code', 'MENTORSHIP_COVER')->value('id');
        $mentorshipCover = Post::getFirstPostByCategory($mentorshipCoverCategoryId);

        $mentorshipPageTitleCategoryId = Category::where('code', 'MENTORSHIP_TITLE')->value('id');
        $mentorshipPageTitle = Post::getFirstPostByCategory($mentorshipPageTitleCategoryId);

        $mentors = Mentor::getPaginateMentorList(8);

        return Inertia::render('Front/Mentorship/Index', [
            'mentorshipCover' => $mentorshipCover,
            'mentors' => $mentors,
            'mentorshipPageTitle' => $mentorshipPageTitle
        ]);
    }
    public function getOpportunities()
    {
        $opportunitiesCoverCategoryId = Category::where('code', 'OPPORTUNITIES_MENU_COVER')->value('id');
        $opportunitiesCover = Post::getFirstPostByCategory($opportunitiesCoverCategoryId);

        $opportunitiesPageTitleCategoryId = Category::where('code', 'OPPORTUNITIES_TITLE')->value('id');
        $opportunitiesPageTitle = Post::getFirstPostByCategory($opportunitiesPageTitleCategoryId);

        $opportunitiesItemCategoryId = Category::where('code', 'OPPORTUNITIES_ITEM')->value('id');
        $opportunities = Post::getPaginatePostByCategory($opportunitiesItemCategoryId, 6);

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
