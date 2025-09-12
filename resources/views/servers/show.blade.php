@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Server Details: {{ $server->name }}</h4>
                    <div>
                        <a href="{{ route('servers.edit', $server) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('servers.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Server Name:</div>
                        <div class="col-md-8">{{ $server->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">IP Address:</div>
                        <div class="col-md-8">{{ $server->ip_address }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Provider:</div>
                        <div class="col-md-8">
                            <span class="badge bg-secondary text-capitalize">{{ $server->provider }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Status:</div>
                        <div class="col-md-8">
                            @if($server->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @elseif($server->status == 'inactive')
                                <span class="badge bg-secondary">Inactive</span>
                            @else
                                <span class="badge bg-warning text-dark">Maintenance</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">CPU Cores:</div>
                        <div class="col-md-8">{{ $server->cpu_cores }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">RAM:</div>
                        <div class="col-md-8">{{ number_format($server->ram_mb) }} MB</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Storage:</div>
                        <div class="col-md-8">{{ number_format($server->storage_gb) }} GB</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Created At:</div>
                        <div class="col-md-8">{{ $server->created_at->format('M d, Y H:i:s') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Updated At:</div>
                        <div class="col-md-8">{{ $server->updated_at->format('M d, Y H:i:s') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
