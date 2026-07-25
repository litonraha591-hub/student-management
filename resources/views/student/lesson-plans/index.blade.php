@extends('layouts.app')
@section('title', 'Lesson Plans')
@section('page-title', 'Lesson Plans')
@section('content')

<div class="card shadow-sm border-0 mb-4" style="border-radius:12px;">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Filter by Exam Type</label>
                <select name="type" class="form-select" onchange="this.form.submit()">
                    <option value="">All Types</option>
                    <option value="mid" {{ request('type') == 'mid' ? 'selected' : '' }}>Mid Term</option>
                    <option value="final" {{ request('type') == 'final' ? 'selected' : '' }}>Final Term</option>
                </select>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0" style="border-radius:12px;">
    <div class="card-body">
        @if($plans->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead style="background:#f0f4ff;">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Date</th>
                        <th>Topic</th>
                        <th>Subject</th>
                        <th>Teacher</th>
                        <th>Type</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plans as $plan)
                    <tr>
                        <td class="ps-4">{{ $plans->firstItem() + $loop->index }}</td>
                        <td>{{ $plan->plan_date->format('M d, Y') }}</td>
                        <td><strong>{{ $plan->title }}</strong></td>
                        <td>{{ $plan->subject->name ?? '-' }}</td>
                        <td>{{ $plan->teacher->name ?? '-' }}</td>
                        <td>
                            @if($plan->type == 'mid')
                                <span class="badge bg-warning text-dark">Mid Term</span>
                            @else
                                <span class="badge bg-success">Final Term</span>
                            @endif
                        </td>
                        <td><small class="text-muted">{{ Str::limit($plan->description, 50) ?? '-' }}</small></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $plans->links() }}
        @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-book-open fa-3x mb-3"></i>
                <h5>No lesson plans available</h5>
                <p>Your teacher hasn't posted any lesson plans yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection
