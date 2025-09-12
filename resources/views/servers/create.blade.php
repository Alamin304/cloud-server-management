@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Add New Server</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('servers.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Server Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="ip_address" class="form-label">IP Address (IPv4) *</label>
                                <input type="text" class="form-control @error('ip_address') is-invalid @enderror"
                                       id="ip_address" name="ip_address" value="{{ old('ip_address') }}" required>
                                @error('ip_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="provider" class="form-label">Provider *</label>
                                <select class="form-select @error('provider') is-invalid @enderror"
                                        id="provider" name="provider" required>
                                    <option value="">Select Provider</option>
                                    <option value="aws" {{ old('provider') == 'aws' ? 'selected' : '' }}>AWS</option>
                                    <option value="digitalocean" {{ old('provider') == 'digitalocean' ? 'selected' : '' }}>DigitalOcean</option>
                                    <option value="vultr" {{ old('provider') == 'vultr' ? 'selected' : '' }}>Vultr</option>
                                    <option value="other" {{ old('provider') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('provider')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="cpu_cores" class="form-label">CPU Cores *</label>
                                <input type="number" class="form-control @error('cpu_cores') is-invalid @enderror"
                                       id="cpu_cores" name="cpu_cores" value="{{ old('cpu_cores') }}"
                                       min="1" max="128" required>
                                @error('cpu_cores')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="ram_mb" class="form-label">RAM (MB) *</label>
                                <input type="number" class="form-control @error('ram_mb') is-invalid @enderror"
                                       id="ram_mb" name="ram_mb" value="{{ old('ram_mb') }}"
                                       min="512" max="1048576" required>
                                @error('ram_mb')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="storage_gb" class="form-label">Storage (GB) *</label>
                                <input type="number" class="form-control @error('storage_gb') is-invalid @enderror"
                                       id="storage_gb" name="storage_gb" value="{{ old('storage_gb') }}"
                                       min="10" max="1048576" required>
                                @error('storage_gb')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('servers.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Server</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
