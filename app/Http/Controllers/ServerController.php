<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ServerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Server::query();

        // Apply filters
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        if ($request->has('provider') && !empty($request->provider)) {
            $query->where('provider', $request->provider);
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Sorting
        $sortField = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortField, $sortOrder);

        $servers = $query->paginate(10)->withQueryString();

        return view('servers.index', compact('servers'));
    }

    public function create()
    {
        return view('servers.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            Server::validationRules(),
            Server::validationMessages()
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Server::create($request->all());
            return redirect()->route('servers.index')
                ->with('success', 'Server created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Server creation failed: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Server $server)
    {
        return view('servers.show', compact('server'));
    }

    public function edit(Server $server)
    {
        return view('servers.edit', compact('server'));
    }

    public function update(Request $request, Server $server)
    {
        $validator = Validator::make(
            $request->all(),
            Server::validationRules($server->id),
            Server::validationMessages()
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $server->update($request->all());
            return redirect()->route('servers.index')
                ->with('success', 'Server updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Server update failed: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Server $server)
    {
        try {
            $server->delete();
            return redirect()->route('servers.index')
                ->with('success', 'Server deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('servers.index')
                ->with('error', 'Server deletion failed: ' . $e->getMessage());
        }
    }

    public function bulkDestroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:servers,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Invalid server IDs provided.');
        }

        try {
            Server::whereIn('id', $request->ids)->delete();
            return redirect()->route('servers.index')
                ->with('success', 'Servers deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('servers.index')
                ->with('error', 'Bulk deletion failed: ' . $e->getMessage());
        }
    }
}
