@extends('layouts.app')
@section('title', 'Notices')
@section('page-title', 'Notice Board')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><div></div>
    <a href="{{ route('admin.notices.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Publish Notice</a>
</div>
<div class="card shadow-sm border-0"><div class="card-body">
    <table class="table table-hover" id="dataTable">
        <thead class="table-light"><tr><th>#</th><th>Title</th><th>Visibility</th><th>Expiry</th><th>By</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>@foreach($notices as $n)<tr>
            <td>{{ $loop->iteration }}</td><td>{{ $n->title }}</td>
            <td><span class="badge bg-info">{{ ucfirst($n->visibility) }}</span></td>
            <td>{{ $n->expiry_date ? $n->expiry_date->format('M d, Y') : 'Never' }}</td>
            <td>{{ $n->creator->name ?? '-' }}</td><td>{{ $n->created_at->format('M d, Y') }}</td>
            <td><a href="{{ route('admin.notices.edit', $n) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                <form method="POST" action="{{ route('admin.notices.destroy', $n) }}" class="d-inline">@csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>@endforeach</tbody>
    </table>
</div></div>
@endsection
