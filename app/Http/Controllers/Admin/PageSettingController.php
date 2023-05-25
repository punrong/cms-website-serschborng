<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\PageSetting;

class PageSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:page-settings list', ['only' => ['index', 'show']]);
        $this->middleware('can:page-settings edit', ['only' => ['edit', 'update']]);
    }

    public function index()
    {
        $pageSetting = PageSetting::first();
        $pageSetting->logo = $pageSetting->logo ? asset($pageSetting->logo) : null;
        $pageSetting->favicon = $pageSetting->favicon ? asset($pageSetting->favicon) : null;
        return Inertia::render('Admin/Page/Detail', [
            'page_settings' => $pageSetting,
            'can' => [
                'edit' => Auth::user()->can('page-settings edit'),
            ]
        ]);
    }
    public function edit(PageSetting $pageSetting)
    {
        $pageSetting->logo = $pageSetting->logo ? asset($pageSetting->logo) : null;
        $pageSetting->favicon = $pageSetting->favicon ? asset($pageSetting->favicon) : null;
        return Inertia::render('Admin/Page/Edit',[
            'page_settings' => $pageSetting,
        ]);
    }

    public function update(PageSetting $pageSetting, Request $request)
    {
        $this->validateRequest($request);
        $this->assignValue($request, $pageSetting);
        if ($pageSetting->save())
            return response()->json([
                'success' => true,
            ]);
    }

    public function getPageSetting(){
        return PageSetting::first();
    }

    private function validateRequest($request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone_number' => ['string', 'max:20','regex:/^\d{9,10}$/'],
            'facebook' => ['required', 'string', 'max:255'],
            'logo' => 'max:2048',
            'favicon' => 'max:2048',
            'description' => ['required', 'string'],
            'copyrights' => ['required', 'string', 'max:255'],
        ]);
    }

    private function assignValue($request, $pageSetting)
    {
        $pageSetting->name = $request->name;
        $pageSetting->email = $request->email;
        $pageSetting->copyrights = $request->copyrights;
        $pageSetting->facebook = $request->facebook;
        $pageSetting->phone_number = $request->phone_number;
        $pageSetting->description = $request->description;
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $imageName = 'logo.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $pageSetting->logo = 'images/' . $imageName;
        }
        if ($request->hasFile('favicon')) {
            $image = $request->file('favicon');
            $imageName = 'favicon.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $pageSetting->favicon = 'images/' . $imageName;
        }
    }
}
