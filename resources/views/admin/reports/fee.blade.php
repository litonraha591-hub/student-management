@extends('layouts.app')
@section('title', 'Fee Report')
@section('page-title', 'Fee Report')
@section('content')
<div class="row g-3 mb-4">
    <div class="col"><div class="card text-center p-3"><h4 class="text-primary mb-0">${{ number_format($summary['total'], 2) }}</h4><small>Total Fees</small></div></div>
    <div class="col"><div class="card text-center p-3"><h4 class="text-success mb-0">${{ number_format($summary['paid'], 2) }}</h4><small>Collected</small></div></div>
    <div class="col"><div class="card text-center p-3"><h4 class="text-danger mb-0">${{ number_format($summary['pending'], 2) }}</h4><small>Pending</small></div></div>
</div>
<div class="row g-3 mb-4">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0"><div class="card-body">
            <h6 class="mb-3">Monthly Collections</h6>
            <canvas id="monthlyChart" height="120"></canvas>
        </div></div>
    </div>
    <div class="col-lg-3">
        <div class="card shadow-sm border-0"><div class="card-body">
            <h6 class="mb-3">Collection by Class</h6>
            <canvas id="classChart" height="120"></canvas>
        </div></div>
    </div>
    <div class="col-lg-3">
        <div class="card shadow-sm border-0"><div class="card-body">
            <h6 class="mb-3">By Fee Type</h6>
            <canvas id="feeTypeChart" height="120"></canvas>
        </div></div>
    </div>
</div>

<div class="card shadow-sm border-0 mt-3"><div class="card-body">
    <table class="table table-hover" id="dataTable">
        <thead class="table-light"><tr><th>Student</th><th>Fee</th><th>Amount</th><th>Paid</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
        @foreach($payments as $p)
            <tr>
                <td>{{ $p->student->user->name ?? '-' }}</td>
                <td>{{ $p->fee->name ?? '-' }}</td>
                <td>${{ number_format($p->fee->amount, 2) }}</td>
                <td>${{ number_format($p->amount_paid, 2) }}</td>
                <td><span class="badge bg-{{ $p->status == 'paid' ? 'success' : ($p->status == 'partial' ? 'warning' : 'danger') }}">{{ ucfirst($p->status) }}</span></td>
                <td>{{ $p->payment_date?->format('M d, Y') ?? '-' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div></div>
@endsection

@section('scripts')
<script>
    const monthlyData = {!! json_encode($monthlyCollections ?? []) !!};
    const classData = {!! json_encode($classCollections ?? []) !!};
    const feeTypeData = {!! json_encode($feeTypeCollections ?? []) !!};

    function drawBarChart(ctxId, labels, data, label){
        const ctx = document.getElementById(ctxId).getContext('2d');
        new Chart(ctx, { type: 'bar', data: { labels, datasets: [{ label, data, backgroundColor: 'rgba(79,70,229,0.8)' }] }, options: { responsive: true, scales: { y: { beginAtZero: true } } } });
    }

    function drawPieChart(ctxId, labels, data){
        const ctx = document.getElementById(ctxId).getContext('2d');
        new Chart(ctx, { type: 'pie', data: { labels, datasets: [{ data, backgroundColor: labels.map((_,i)=> `hsl(${i*40 % 360} 70% 50%)`) }] }, options: { responsive: true } });
    }

    // Monthly
    const monthlyLabels = Object.keys(monthlyData);
    const monthlyValues = Object.values(monthlyData).map(v => Number(v));
    if(monthlyLabels.length) drawBarChart('monthlyChart', monthlyLabels, monthlyValues, 'Collected');

    // Class-wise
    const classLabels = Object.keys(classData);
    const classValues = Object.values(classData).map(v => Number(v));
    if(classLabels.length) drawBarChart('classChart', classLabels, classValues, 'Collected');

    // Fee type pie
    const feeLabels = Object.keys(feeTypeData);
    const feeValues = Object.values(feeTypeData).map(v => Number(v));
    if(feeLabels.length) drawPieChart('feeTypeChart', feeLabels, feeValues);
</script>
@endsection
