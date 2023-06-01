<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Savannabits\PrimevueDatatables\PrimevueDatatables;
use Illuminate\Http\JsonResponse;
class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:category list', ['only' => ['index', 'show']]);
        $this->middleware('can:category create', ['only' => ['create', 'store']]);
        $this->middleware('can:category edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:category delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return Inertia::render('Admin/Category/Index', [
            'can' => [
                'create' => Auth::user()->can('category create'),
                'edit' => Auth::user()->can('category edit'),
                'delete' => Auth::user()->can('category delete'),
            ]
        ]);
    }

    public function getCategoryData(Request $request): JsonResponse {
        $sortField = $request->sortField ?? 'id';
        $sortOrder = $request->sortOrder ?? 'desc';

        return response()->json([
            'success' => true,
            'payload' => PrimevueDatatables::of(Category::select('id', 'name', 'code', 'description', 'status', 'sequence')->where('status', '!=', 'DEL')->orderBy($sortField, $sortOrder))->make()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Category/Create');
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        $category = new Category();
        $this->assignValue($request, $category);
        if ($category->save())
            return response()->json([
                'success' => true,
            ]);
    }

    public function show(Category $category)
    {
        return Inertia::render('Admin/Category/Detail', [
            'category' => $category,
            'can' => [
                'edit' => Auth::user()->can('category edit'),
            ]
        ]);
    }

    public function edit(Category $category, Request $request)
    {
        return Inertia::render('Admin/Category/Edit', [
            'category' => $category,
            'isTriggeredFromTable' => $request->isTriggeredFromTable ?? false
        ]);
    }

    public function update(Category $category, Request $request)
    {
        $this->validateRequest($request, $category);
        $this->assignValue($request, $category);
        if ($category->save())
            return response()->json([
                'success' => true,
            ]);
    }

    public function destroy(Category $category)
    {
        $category->status = 'DEL';
        $category->updated_by = Auth::user()->id;
        if ($category->save())
            return response()->json([
                'success' => true,
            ]);
    }

    public function deleteMultipleRecord(Request $request)
    {
        $categoryIdList = array_column($request->categoryList, 'id');
        if (Category::whereIn('id', $categoryIdList)->update(['status' => 'DEL', 'updated_by' => Auth::user()->id]))
            return response()->json([
                'success' => true,
            ]);
    }

    public function getCategoryList(){
        return Category::getCategoryList();
    }

    public function getCategoryArray(){
        return Category::getCategoryArray();
    }

    private function validateRequest($request, $category = null)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'status' => 'required',
            'code' => ['required','string', isset($category) ? 'unique:categories,code,' . $category->id . ',id' : 'unique:categories'],
            // 'sequence' => ['numeric','integer','min:1'],
        ]);
    }

    private function assignValue($request, $category)
    {
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status;
        $category->sequence = $request->sequence ?? $request->sequence;
        $category->code = $request->code;
        if(isset($category->id))
            $category->updated_by = Auth::user()->id;
        else
            $category->created_by = Auth::user()->id;
    }
}
