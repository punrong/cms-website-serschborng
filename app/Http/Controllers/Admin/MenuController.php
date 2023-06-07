<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function getAboutUs(){
        return Inertia::render('Front/AboutUs');
    }
    public function getMentorship(){
        return Inertia::render('Front/Mentorship');
    }
    public function getOpportunities(){
        return Inertia::render('Front/Opportunities');
    }
    public function getBlog(){
        return Inertia::render('Front/Blog');
    }
}
