<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\JoinOurNetwork;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Savannabits\PrimevueDatatables\PrimevueDatatables;
use Illuminate\Http\JsonResponse;

class JoinOurNetworkController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:category list', ['only' => ['index', 'show']]);
    }

    public function index()
    {
        return Inertia::render('Admin/JoinOurNetwork/Index');
    }

    public function getOurNetworkData(Request $request): JsonResponse {
        $sortField = $request->sortField ?? 'id';
        $sortOrder = $request->sortOrder ?? 'desc';

        return response()->json([
            'success' => true,
            'payload' => PrimevueDatatables::of(JoinOurNetwork::select('id', 'email')->orderBy($sortField, $sortOrder))->make()
        ]);
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        $ourNetwork = new JoinOurNetwork();
        $this->assignValue($request, $ourNetwork);
        if ($ourNetwork->save())
            return response()->json([
                'success' => true,
            ]);
    }

    private function validateRequest($request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);
    }

    private function assignValue($request, $ourNetwork)
    {
        $ourNetwork->email = $request->email;
    }
}
