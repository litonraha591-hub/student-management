@extends('layouts.app')
@section('title', 'Fee Payments')
@section('page-title', 'Payments: ' . $fee->name)
@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h6>Fee Details</h6>
        <p class="mb-0">{{ $fee->name }} | ${{ number_format($fee->amount, 2) }} | {{ ucfirst($fee->type) }}</p>
    </div>
</div>
<div class="card shadow-sm border-0"><div class="card-body">
    <table class="table table-hover" id="dataTable">
        <thead class="table-light"><tr><th>Invoice</th><th>Student</th><th>Amount Paid</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>@foreach($payments as $p)<tr>
            <td>{{ $p->invoice_number ?? '-' }}</td><td>{{ $p->student->user->name ?? '-' }}</td>
            <td>${{ number_format($p->amount_paid, 2) }}</td>
            <td><span class="badge bg-{{ $p->status == 'paid' ? 'success' : ($p->status == 'partial' ? 'warning' : 'danger') }}">{{ ucfirst($p->status) }}</span></td>
            <td>{{ $p->payment_date?->format('M d, Y') ?? '-' }}</td>
            <td>@if($p->status != 'paid')<form method="POST" action="{{ route('admin.fees.mark-paid', $p) }}">@csrf
                <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-check me-1"></i>Mark Paid</button>
            </form>@endif</td>
        </tr>@endforeach</tbody>
    </table>
</div></div>
@endsection
