@extends('layouts.app')
@section('title', 'Lesson Plans')
@section('page-title', 'Lesson Plans')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <a href="{{ route('teacher.lesson-plans.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Lesson Plan</a>
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
                        <th>Title</th>
                        <th>Subject</th>
                        <th>Class</th>
                        <th>Shift</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plans as $plan)
                    <tr>
                        <td class="ps-4">{{ $plans->firstItem() + $loop->index }}</td>
                        <td>{{ $plan->plan_date->format('M d, Y') }}</td>
                        <td><strong>{{ $plan->title }}</strong></td>
                        <td>{{ $plan->subject->name ?? '-' }}</td>
                        <td>{{ $plan->class->name ?? '-' }}</td>
                        <td><span class="badge bg-info text-dark">{{ $plan->section->name ?? '-' }}</span></td>
                        <td>
                            @if($plan->type == 'mid')
                                <span class="badge bg-warning text-dark">Mid Term</span>
                            @else
                                <span class="badge bg-success">Final Term</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('teacher.lesson-plans.edit', $plan) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('teacher.lesson-plans.destroy', $plan) }}" class="d-inline">@csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $plans->links() }}
        @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-book-open fa-3x mb-3"></i>
                <h5>No lesson plans yet</h5>
                <p>Create your first lesson plan to get started.</p>
                <a href="{{ route('teacher.lesson-plans.create') }}" class="btn btn-primary mt-2"><i class="fas fa-plus me-2"></i>Add Lesson Plan</a>
            </div>
        @endif
    </div>
</div>
@endsection
