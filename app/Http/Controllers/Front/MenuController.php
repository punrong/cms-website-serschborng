<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

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
        return Inertia::render('Front/Blog/Blog');
    }
}
