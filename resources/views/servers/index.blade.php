@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-md-6">
            <h1>Server Management</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('servers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Server
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter Card -->
    <div class="card mb-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Filter Servers</h5>
            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse"
                    data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                <i class="fas fa-filter"></i> Toggle Filters
            </button>
        </div>
        <div class="collapse {{ request()->hasAny(['search', 'provider', 'status']) ? 'show' : '' }}" id="filterCollapse">
            <div class="card-body">
                <form method="GET" action="{{ route('servers.index') }}">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="{{ request('search') }}" placeholder="Search by name or IP">
                        </div>
                        <div class="col-md-3">
                            <label for="provider" class="form-label">Provider</label>
                            <select class="form-select" id="provider" name="provider">
                                <option value="">All Providers</option>
                                <option value="aws" {{ request('provider') == 'aws' ? 'selected' : '' }}>AWS</option>
                                <option value="digitalocean" {{ request('provider') == 'digitalocean' ? 'selected' : '' }}>DigitalOcean</option>
                                <option value="vultr" {{ request('provider') == 'vultr' ? 'selected' : '' }}>Vultr</option>
                                <option value="other" {{ request('provider') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">All Statuses</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bulk Delete Form -->
    <form id="bulkForm">
        @csrf
        <div class="card">
            <div class="card-body p-0">
                <!-- Bulk Delete Button -->
                <div class="mb-2 d-flex justify-content-end p-2">
                    <button type="button" class="btn btn-danger" id="bulkDeleteBtn" disabled>
                        <i class="fas fa-trash"></i> Delete Selected
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50"><input type="checkbox" id="selectAll"></th>
                                <th>Name</th>
                                <th>IP Address</th>
                                <th>Provider</th>
                                <th>Status</th>
                                <th>CPU Cores</th>
                                <th>RAM (MB)</th>
                                <th>Storage (GB)</th>
                                <th>Created</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($servers as $server)
                            <tr id="server-{{ $server->id }}">
                                <td><input type="checkbox" class="server-checkbox" value="{{ $server->id }}"></td>
                                <td>{{ $server->name }}</td>
                                <td>{{ $server->ip_address }}</td>
                                <td>{{ $server->provider }}</td>
                                <td>
                                    @if($server->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @elseif($server->status == 'inactive')
                                        <span class="badge bg-secondary">Inactive</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Maintenance</span>
                                    @endif
                                </td>
                                <td>{{ $server->cpu_cores }}</td>
                                <td>{{ number_format($server->ram_mb) }}</td>
                                <td>{{ number_format($server->storage_gb) }}</td>
                                <td>{{ $server->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('servers.show', $server) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('servers.edit', $server) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('servers.destroy', $server) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this server?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">No servers found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if($servers->hasPages())
            <div class="card-footer">
                <nav aria-label="Server pagination">
                    <ul class="pagination mb-0">
                        @if ($servers->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">&laquo; Previous</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $servers->previousPageUrl() }}" rel="prev">&laquo; Previous</a></li>
                        @endif

                        @foreach ($servers->getUrlRange(1, $servers->lastPage()) as $page => $url)
                            @if ($page == $servers->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        @if ($servers->hasMorePages())
                            <li class="page-item"><a class="page-link" href="{{ $servers->nextPageUrl() }}" rel="next">Next &raquo;</a></li>
                        @else
                            <li class="page-item disabled"><span class="page-link">Next &raquo;</span></li>
                        @endif
                    </ul>
                    <div class="mt-2 text-muted small">
                        Showing {{ $servers->firstItem() }} to {{ $servers->lastItem() }} of {{ $servers->total() }} results
                    </div>
                </nav>
            </div>
            @endif
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.server-checkbox');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

    function updateBulkDeleteButton() {
        const checkedCount = [...checkboxes].filter(cb => cb.checked).length;
        bulkDeleteBtn.disabled = checkedCount === 0;
        bulkDeleteBtn.textContent = checkedCount > 0 ? `Delete Selected (${checkedCount})` : 'Delete Selected';
    }

    selectAll.addEventListener('change', () => {
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
        updateBulkDeleteButton();
    });

    checkboxes.forEach(cb => cb.addEventListener('change', () => {
        updateBulkDeleteButton();
        selectAll.checked = [...checkboxes].every(cb => cb.checked);
    }));

    bulkDeleteBtn.addEventListener('click', () => {
        const ids = [...checkboxes].filter(cb => cb.checked).map(cb => cb.value);
        if(ids.length === 0) return;
        if(!confirm(`Are you sure you want to delete ${ids.length} server(s)?`)) return;

        fetch("{{ route('servers.bulk-delete') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ ids })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                ids.forEach(id => {
                    const row = document.getElementById(`server-${id}`);
                    if(row) row.remove();
                });
                bulkDeleteBtn.disabled = true;
                selectAll.checked = false;
                updateBulkDeleteButton();
                alert(data.message);
            } else {
                alert(data.message);
            }
        })
        .catch(() => alert('Bulk deletion failed.'));
    });
});
</script>
@endpush
