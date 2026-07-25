@extends('layouts.app')
@section('title', 'My Routine')
@section('page-title', 'My Routine')
@section('content')
<div class="row g-4">
    <div class="col-xl-4">
        <div class="card shadow-sm border-0"><div class="card-header bg-primary text-white"><h6 class="mb-0"><i class="fas fa-calendar-day me-2"></i>Today's Classes</h6></div><div class="card-body">
            @forelse($todayClasses as $c)
            <div class="d-flex border-bottom py-2">
                <div class="bg-light rounded p-2 me-3 text-center" style="min-width:70px"><strong>{{ $c->start_time }}</strong><br><small>{{ $c->end_time }}</small></div>
                <div><strong>{{ $c->subject->name }}</strong><br><small class="text-muted">{{ $c->class->name }} - {{ $c->section->name }}</small></div>
            </div>
            @empty <p class="text-muted text-center py-3">No classes today</p>@endforelse
        </div></div>
    </div>
    <div class="col-xl-8">
        <div class="card shadow-sm border-0"><div class="card-header bg-white"><h6 class="mb-0"><i class="fas fa-table me-2"></i>Weekly Routine</h6></div><div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light"><tr><th>Day</th><th>Time</th><th>Subject</th><th>Class</th><th>Shift</th><th>Room</th></tr></thead>
                    <tbody>@foreach($weeklyRoutine as $r)<tr><td><span class="badge bg-primary">{{ ucfirst($r->day) }}</span></td><td>{{ $r->start_time }} - {{ $r->end_time }}</td><td>{{ $r->subject->name }}</td><td>{{ $r->class->name }}</td><td>{{ $r->section->name }}</td><td>{{ $r->room ?? '-' }}</td></tr>@endforeach</tbody>
                </table>
            </div>
        </div></div>
    </div>
</div>
@endsection
