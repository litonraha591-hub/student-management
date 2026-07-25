@extends('layouts.app')
@section('title', 'Publish Notice')
@section('page-title', 'Publish Notice')
@section('content')
<div class="card shadow-sm border-0"><div class="card-body">
    <form method="POST" action="{{ route('admin.notices.store') }}" enctype="multipart/form-data">@csrf
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Title</label><input type="text" name="title" class="form-control" value="{{ old('title') }}" required></div>
            <div class="col-md-3"><label class="form-label">Visibility</label><select name="visibility" class="form-select"><option value="all">All</option><option value="students">Students</option><option value="teachers">Teachers</option><option value="parents">Parents</option></select></div>
            <div class="col-md-3"><label class="form-label">Expiry Date</label><input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date') }}"></div>
            <div class="col-12"><label class="form-label">Content</label><textarea name="content" class="form-control" rows="5" required>{{ old('content') }}</textarea></div>
            <div class="col-md-6"><label class="form-label">Attachment (PDF/Image)</label><input type="file" name="attachment" class="form-control"></div>
        </div>
        <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-2"></i>Publish</button> <a href="{{ route('admin.notices.index') }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div></div>
@endsection
