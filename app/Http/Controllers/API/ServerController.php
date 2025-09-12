<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ServerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = Server::query();

        // Search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        // Filter by provider
        if ($request->has('provider') && !empty($request->provider)) {
            $query->where('provider', $request->provider);
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Sorting
        $sortField = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortField, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 10);
        return $query->paginate($perPage);
    }

    // public function store(Request $request)
    // {
    //     $validator = Validator::make(
    //         $request->all(),
    //         Server::validationRules(),
    //         Server::validationMessages()
    //     );

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'message' => 'Validation failed',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     try {
    //         $server = Server::create($request->all());
    //         return response()->json($server, 201);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Server creation failed',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            Server::validationRules(),
            Server::validationMessages()
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();
            $data['version'] = 0;
            $server = Server::create($data);
            return response()->json($server, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Server creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $server = Server::find($id);

        if (!$server) {
            return response()->json(['message' => 'Server not found'], 404);
        }

        return response()->json($server);
    }

    public function update(Request $request, $id)
{
    $server = Server::find($id);

    if (!$server) {
        return response()->json(['message' => 'Server not found'], 404);
    }

    // Check version to prevent race conditions
    if ($server->version != $request->version) {
        return response()->json([
            'message' => 'Server has been modified by another user. Please refresh and try again.'
        ], 409);
    }

    $validator = Validator::make(
        $request->all(),
        Server::validationRules($id),
        Server::validationMessages()
    );

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $data = $request->all();
        $data['version'] = $server->version + 1;
        $server->update($data);

        return response()->json($server);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Server update failed',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function destroy($id)
    {
        $server = Server::find($id);

        if (!$server) {
            return response()->json(['message' => 'Server not found'], 404);
        }

        try {
            $server->delete();
            return response()->json(['message' => 'Server deleted successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Server deletion failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function bulkDestroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:servers,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            Server::whereIn('id', $request->ids)->delete();
            return response()->json(['message' => 'Servers deleted successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Bulk deletion failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
