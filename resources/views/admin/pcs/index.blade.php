@extends('admin.layouts.app')

@section('title','PC Builds')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">All PCs</h4>
        <a href="{{ route('admin.pcs.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-1"></i> New PC
        </a>
    </div>

    {{-- flash success --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-1"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th class="text-end">Price (MAD)</th>
                        <th class="text-center">Parts</th>
                        <th>Created</th>
                        <th style="width:120px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($pcs as $pc)
                        <tr>
                            <td>{{ $pc->id }}</td>

                            <td>{{ $pc->name }}</td>

                            <td>
                            <span class="badge
                                {{ $pc->is_prebuilt ? 'bg-success' : 'bg-secondary' }}">
                                {{ $pc->is_prebuilt ? 'Pre-built' : 'Custom' }}
                            </span>
                            </td>

                            <td class="text-end">
                                {{ number_format($pc->price, 0) }}
                            </td>

                            <td class="text-center">
                                {{ $pc->items_count }}
                            </td>

                            <td>{{ $pc->created_at->format('Y-m-d') }}</td>

                            <td>
                                <a href="{{ route('admin.pcs.edit', $pc) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="fa fa-pen"></i>
                                </a>

                                <form action="{{ route('admin.pcs.destroy', $pc->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this PC?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No PCs yet.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($pcs->hasPages())
            <div class="card-footer">
                {{ $pcs->links() }}
            </div>
        @endif
    </div>
@endsection
