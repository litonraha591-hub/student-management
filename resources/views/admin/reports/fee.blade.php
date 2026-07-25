@extends('layouts.app')
@section('title', 'Fee Report')
@section('page-title', 'Fee Report')
@section('content')
<div class="row g-3 mb-4">
    <div class="col"><div class="card text-center p-3"><h4 class="text-primary mb-0">${{ number_format($summary['total'], 2) }}</h4><small>Total Fees</small></div></div>
    <div class="col"><div class="card text-center p-3"><h4 class="text-success mb-0">${{ number_format($summary['paid'], 2) }}</h4><small>Collected</small></div></div>
    <div class="col"><div class="card text-center p-3"><h4 class="text-danger mb-0">${{ number_format($summary['pending'], 2) }}</h4><small>Pending</small></div></div>
</div>
<div class="card shadow-sm border-0"><div class="card-body">
    <table class="table table-hover" id="dataTable">
        <thead class="table-light"><tr><th>Student</th><th>Fee</th><th>Amount</th><th>Paid</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>@foreach($payments as $p)<tr><td>{{ $p->student->user->name ?? '-' }}</td><td>{{ $p->fee->name ?? '-' }}</td>
            <td>${{ number_format($p->fee->amount, 2) }}</td><td>${{ number_format($p->amount_paid, 2) }}</td>
            <td><span class="badge bg-{{ $p->status == 'paid' ? 'success' : ($p->status == 'partial' ? 'warning' : 'danger') }}">{{ ucfirst($p->status) }}</span></td>
            <td>{{ $p->payment_date?->format('M d, Y') ?? '-' }}</td></tr>@endforeach</tbody>
    </table>
</div></div>
@endsection
