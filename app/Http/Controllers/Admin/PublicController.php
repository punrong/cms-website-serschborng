<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\PageSetting;

class PublicController extends Controller
{
    public function getPageSettingData(){
        return PageSetting::first();
    }

    public function getCoverData(){
        $coverCategoryId = Category::where('code', 'COVER')->value('id');
        return Post::getFirstPostByCategory($coverCategoryId);
    }

    public function getJoinUsData(){
        $joinUsId = Category::where('code', 'JOIN_US')->value('id');
        return Post::getFirstPostByCategory($joinUsId);
    }

    public function getFeatureData(){
        $featureId = Category::where('code', 'FEATURES')->value('id');
        return Post::getTopThreePostByCategory($featureId);
    }

    public function getAboutUsTextData(){
        $aboutUsTextId = Category::where('code', 'ABOUT_US')->value('id');
        return Post::getFirstPostByCategory($aboutUsTextId);
    }

    public function getAboutUsCardData(){
        $aboutUsCardId = Category::where('code', 'ABOUT_US_C')->value('id');
        return Post::getFirstPostByCategory($aboutUsCardId);
    }

    public function getOurMissionData(){
        $missionId = Category::where('code', 'MISSION')->value('id');
        return Post::getFirstPostByCategory($missionId);
    }

    public function getOurHeroTitleData(){
        $ourHeroTitleId = Category::where('code', 'HERO_TITLE')->value('id');
        return Post::getFirstPostByCategory($ourHeroTitleId);
    }

    public function getOurHeroItemData(){
        $ourHeroItemId = Category::where('code', 'HERO_ITEM')->value('id');
        return Post::getFirstPostByCategory($ourHeroItemId);
    }
}
