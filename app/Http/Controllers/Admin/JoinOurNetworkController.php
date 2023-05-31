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
        $this->middleware('can:join-our-networks list', ['only' => ['index', 'show']]);
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
            'payload' => PrimevueDatatables::of(JoinOurNetwork::select('id', 'name', 'email')->orderBy($sortField, $sortOrder))->make()
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

    public function show(JoinOurNetwork $join_our_network)
    {
        return Inertia::render('Admin/JoinOurNetwork/Detail', [
            'join_our_network' => $join_our_network,
        ]);
    }

    private function validateRequest($request)
    {
        $request->validate([
            'name' => ['required','string', 'max:255'],
            'email' => ['required','email', 'max:255'],
        ]);
    }

    private function assignValue($request, $ourNetwork)
    {
        $ourNetwork->name = $request->name;
        $ourNetwork->email = $request->email;
        $ourNetwork->message = $request->message;
    }
}
