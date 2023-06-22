<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        $categoryList = [
            ['name' => 'Home - Cover', 'code' => 'HOME_COVER'],
            ['name' => 'Home - Features', 'code' => 'HOME_FEATURES'],
            ['name' => 'Home - About Us Left Text', 'code' => 'HOME_ABOUT_US_LEFT_TEXT'],
            ['name' => 'Home - About Us Card', 'code' => 'ABOUT_US_CARD'],
            ['name' => 'Home - Our Mission', 'code' => 'HOME_OUR_MISSION'],
            ['name' => 'Home - Testimonial Title', 'code' => 'HOME_TESTIMONIAL_TITLE'],
            ['name' => 'Home - Testimonial Item', 'code' => 'HOME_TESTIMONIAL_ITEM'],
            ['name' => 'Home - Our Team Title', 'code' => 'HOME_OUR_TEAM_TITLE'],
            ['name' => 'Home - Our Team Item', 'code' => 'HOME_OUR_TEAM_ITEM'],
            ['name' => 'Home - Our Recent Works Title', 'code' => 'HOME_RECENT_WORK_TITLE'],
            ['name' => 'Home - Our Recent Works Item', 'code' => 'HOME_RECENT_WORK_ITEM'],
            ['name' => 'Home & Blog Page - Blog Post Title', 'code' => 'BLOG_TITLE'],
            ['name' => 'Home & Blog Page - Blog Item', 'code' => 'BLOG_ITEM'],
            ['name' => 'Home - Our Service Title', 'code' => 'HOME_OUR_SERVICE_TITLE'],
            ['name' => 'Home - Our Service Item', 'code' => 'HOME_OUR_SERVICE_ITEM'],
            ['name' => 'Home - Join Us', 'code' => 'HOME_JOIN_US'],
            ['name' => 'About Us Menu - Cover', 'code' => 'MENU_ABOUT_US_COVER'],
            ['name' => 'About Us - Our Story', 'code' => 'ABOUT_US_OUR_STORY'],
            ['name' => 'About Us - Our Founder', 'code' => 'ABOUT_US_OUR_FOUNDER'],
            ['name' => 'Mentorship Menu - Cover', 'code' => 'MENTORSHIP_COVER'],
            ['name' => 'Mentorship Menu - Title', 'code' => 'MENTORSHIP_TITLE'],
            ['name' => 'Opportunities Menu - Cover', 'code' => 'OPPORTUNITIES_MENU_COVER'],
            ['name' => 'Opportunities Menu - Title', 'code' => 'OPPORTUNITIES_TITLE'],
            ['name' => 'Opportunities Menu - Item', 'code' => 'OPPORTUNITIES_ITEM'],
            ['name' => 'Blog Menu - Cover', 'code' => 'MENU_BLOG_COVER'],
        ];
        foreach ($categoryList as $category) {
            Category::create(['name' => $category['name'], 'code' => $category['code'], 'status' => 'ACT']);
        }
    }
}
