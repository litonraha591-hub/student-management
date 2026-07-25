@extends('layouts.app')
@section('title', 'Reports')
@section('page-title', 'Reports')
@section('content')
<div class="row g-4">
    <div class="col-md-4"><a href="{{ route('admin.reports.students') }}" class="card shadow-sm border-0 text-decoration-none h-100"><div class="card-body text-center py-5"><i class="fas fa-user-graduate fa-3x text-primary mb-3"></i><h5>Student Report</h5><p class="text-muted">View all student data and statistics</p></div></a></div>
    <div class="col-md-4"><a href="{{ route('admin.reports.teachers') }}" class="card shadow-sm border-0 text-decoration-none h-100"><div class="card-body text-center py-5"><i class="fas fa-chalkboard-teacher fa-3x text-success mb-3"></i><h5>Teacher Report</h5><p class="text-muted">View all teacher data and assignments</p></div></a></div>
    <div class="col-md-4"><a href="{{ route('admin.reports.attendance') }}" class="card shadow-sm border-0 text-decoration-none h-100"><div class="card-body text-center py-5"><i class="fas fa-check-double fa-3x text-warning mb-3"></i><h5>Attendance Report</h5><p class="text-muted">Monthly and daily attendance summary</p></div></a></div>
    <div class="col-md-4"><a href="{{ route('admin.reports.results') }}" class="card shadow-sm border-0 text-decoration-none h-100"><div class="card-body text-center py-5"><i class="fas fa-chart-bar fa-3x text-info mb-3"></i><h5>Result Report</h5><p class="text-muted">Exam results and performance analysis</p></div></a></div>
    <div class="col-md-4"><a href="{{ route('admin.reports.fees') }}" class="card shadow-sm border-0 text-decoration-none h-100"><div class="card-body text-center py-5"><i class="fas fa-money-bill-wave fa-3x text-danger mb-3"></i><h5>Fee Report</h5><p class="text-muted">Payment status and fee collection</p></div></a></div>
</div>
@endsection
