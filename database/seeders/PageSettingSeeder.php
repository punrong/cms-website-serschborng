<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSetting;

class PageSettingSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        $pageSetting = new PageSetting();
        $pageSetting->name = 'សិស្សច្បង ~ Sers Chborng';
        $pageSetting->email = 'serschborng.info@gmail.com';
        $pageSetting->phone_number = '6803566878';
        $pageSetting->description = '<p>A mentoring platform that unlocks your true potential</p>';
        $pageSetting->facebook = 'https://www.facebook.com/SersChborng/';
        $pageSetting->logo = 'logo.png';
        $pageSetting->copyrights = '© 2023 Sers Chborng™. All Rights Reserved.';
        $pageSetting->favicon = 'favicon.png';
        $pageSetting->instagram = 'https://instagram.com/sers_chborng?igshid=MjEwN2IyYWYwYw==';
        $pageSetting->save();
    }
}
