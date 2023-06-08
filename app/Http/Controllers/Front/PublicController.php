<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\PageSetting;

class PublicController extends Controller
{
    public function getPageSettingData(){
        return PageSetting::first();
    }

    public function getHomeCover(){
        $coverCategoryId = Category::where('code', 'HOME_COVER')->value('id');
        return Post::getFirstPostByCategory($coverCategoryId);
    }

    public function getHomeJoinUs(){
        $joinUsCategoryId = Category::where('code', 'HOME_JOIN_US')->value('id');
        return Post::getFirstPostByCategory($joinUsCategoryId);
    }

    public function getHomeFeatures(){
        $featureCategoryId = Category::where('code', 'HOME_FEATURES')->value('id');
        return Post::getTopThreePostByCategory($featureCategoryId);
    }

    public function getHomeAboutUsLeftText(){
        $aboutUsCategoryId = Category::where('code', 'HOME_ABOUT_US_LEFT_TEXT')->value('id');
        return Post::getFirstPostByCategory($aboutUsCategoryId);
    }

    public function getHomeAboutUsCard(){
        $aboutUsCardCategpryId = Category::where('code', 'ABOUT_US_CARD')->value('id');
        return Post::getFirstPostByCategory($aboutUsCardCategpryId);
    }

    public function getHomeOurMission(){
        $missionCategoryId = Category::where('code', 'HOME_OUR_MISSION')->value('id');
        return Post::getFirstPostByCategory($missionCategoryId);
    }

    public function getHomeOurTeamTitle(){
        $ourHeroTitleCategoryId = Category::where('code', 'HOME_OUR_TEAM_TITLE')->value('id');
        return Post::getFirstPostByCategory($ourHeroTitleCategoryId);
    }

    public function getHomeOurTeamItem(){
        $ourHeroItemCategoryId = Category::where('code', 'HOME_OUR_TEAM_ITEM')->value('id');
        return Post::getFirstPostByCategory($ourHeroItemCategoryId);
    }

    public function getHomeOurServiceTitle(){
        $ourServiceTitleCategoryId = Category::where('code', 'HOME_OUR_SERVICE_TITLE')->value('id');
        return Post::getFirstPostByCategory($ourServiceTitleCategoryId);
    }

    public function getHomeOurServiceItem(){
        $ourServiceItemCategoryId = Category::where('code', 'HOME_OUR_SERVICE_ITEM')->value('id');
        return Post::getTopThreePostByCategory($ourServiceItemCategoryId);
    }

    public function getBlogTitle(){
        $blogPostTitleCategoryId = Category::where('code', 'BLOG_TITLE')->value('id');
        return Post::getFirstPostByCategory($blogPostTitleCategoryId);
    }

    public function getBlogItem(){
        $blogPostItemCategoryId = Category::where('code', 'BLOG_ITEM')->value('id');
        return Post::getTopThreePostByCategory($blogPostItemCategoryId);
    }

    public function getHomeTestimonialTitle(){
        $testimonialTitleCategoryId = Category::where('code', 'HOME_TESTIMONIAL_TITLE')->value('id');
        return Post::getFirstPostByCategory($testimonialTitleCategoryId);
    }

    public function getHomeTestimonialItem(){
        $testimonialItemCategoryId = Category::where('code', 'HOME_TESTIMONIAL_ITEM')->value('id');
        return Post::getAllPostByCategory($testimonialItemCategoryId);
    }

    public function getHomeOurRecentWorkTitle(){
        $recentWorkTitleCategoryId = Category::where('code', 'HOME_RECENT_WORK_TITLE')->value('id');
        return Post::getFirstPostByCategory($recentWorkTitleCategoryId);
    }

    public function getHomeOurRecentWorkItem(){
        $recentWorkItemCategoryId = Category::where('code', 'HOME_RECENT_WORK_ITEM')->value('id');
        return Post::getAllPostByCategory($recentWorkItemCategoryId);
    }
}
