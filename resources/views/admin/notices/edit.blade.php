@extends('layouts.app')
@section('title', 'Edit Notice')
@section('page-title', 'Edit Notice')
@section('content')
<div class="card shadow-sm border-0"><div class="card-body">
    <form method="POST" action="{{ route('admin.notices.update', $notice) }}" enctype="multipart/form-data">@csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Title</label><input type="text" name="title" class="form-control" value="{{ old('title', $notice->title) }}" required></div>
            <div class="col-md-3"><label class="form-label">Visibility</label><select name="visibility" class="form-select"><option value="all" {{ $notice->visibility == 'all' ? 'selected' : '' }}>All</option><option value="students" {{ $notice->visibility == 'students' ? 'selected' : '' }}>Students</option><option value="teachers" {{ $notice->visibility == 'teachers' ? 'selected' : '' }}>Teachers</option></select></div>
            <div class="col-md-3"><label class="form-label">Expiry Date</label><input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date', optional($notice->expiry_date)->format('Y-m-d')) }}"></div>
            <div class="col-12"><label class="form-label">Content</label><textarea name="content" class="form-control" rows="5" required>{{ old('content', $notice->content) }}</textarea></div>
            <div class="col-md-6"><label class="form-label">Attachment</label><input type="file" name="attachment" class="form-control"></div>
        </div>
        <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update</button> <a href="{{ route('admin.notices.index') }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div></div>
@endsection
