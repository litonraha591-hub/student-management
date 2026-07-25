@extends('layouts.app')
@section('title', 'Fees')
@section('page-title', 'Fee Management')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><div></div>
    <a href="{{ route('admin.fees.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Fee Structure</a>
</div>
<div class="card shadow-sm border-0"><div class="card-body">
    <table class="table table-hover" id="dataTable">
        <thead class="table-light"><tr><th>#</th><th>Name</th><th>Type</th><th>Amount</th><th>Class</th><th>Year</th><th>Actions</th></tr></thead>
        <tbody>@foreach($fees as $f)<tr>
            <td>{{ $loop->iteration }}</td><td>{{ $f->name }}</td><td><span class="badge bg-info">{{ ucfirst($f->type) }}</span></td>
            <td>${{ number_format($f->amount, 2) }}</td><td>{{ $f->class->name ?? '-' }}</td><td>{{ $f->academicYear->name ?? '-' }}</td>
            <td><a href="{{ route('admin.fees.payments', $f) }}" class="btn btn-sm btn-outline-success"><i class="fas fa-money-bill"></i></a>
                <form method="POST" action="{{ route('admin.fees.destroy', $f) }}" class="d-inline">@csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>@endforeach</tbody>
    </table>
</div></div>
@endsection
