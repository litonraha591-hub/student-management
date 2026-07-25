@extends('layouts.app')
@section('title', 'Edit Student')
@section('page-title', 'Edit Student')
@section('content')
<form method="POST" action="{{ route('admin.students.update', $student) }}" enctype="multipart/form-data">@csrf @method('PUT')
<div class="card shadow-sm border-0 mb-4"><div class="card-header bg-primary text-white"><i class="fas fa-user me-2"></i>Personal Information</div><div class="card-body">
    <div class="row g-3">
        <div class="col-md-4"><label class="form-label">Full Name *</label><input type="text" name="name" class="form-control" value="{{ old('name', $student->user->name) }}" required></div>
        <div class="col-md-4"><label class="form-label">Email *</label><input type="email" name="email" class="form-control" value="{{ old('email', $student->user->email) }}" required></div>
        <div class="col-md-4"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ old('phone', $student->user->phone) }}"></div>
        <div class="col-md-4"><label class="form-label">Photo</label><input type="file" name="photo" class="form-control" accept="image/*"></div>
        <div class="col-md-3"><label class="form-label">Gender *</label><select name="gender" class="form-select" required><option value="male" {{ $student->gender == 'male' ? 'selected' : '' }}>Male</option><option value="female" {{ $student->gender == 'female' ? 'selected' : '' }}>Female</option><option value="other" {{ $student->gender == 'other' ? 'selected' : '' }}>Other</option></select></div>
        <div class="col-md-3"><label class="form-label">Blood Group</label><input type="text" name="blood_group" class="form-control" value="{{ old('blood_group', $student->blood_group) }}"></div>
        <div class="col-md-3"><label class="form-label">Date of Birth</label><input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', optional($student->date_of_birth)->format('Y-m-d')) }}"></div>
        <div class="col-md-3"><label class="form-label">Religion</label><input type="text" name="religion" class="form-control" value="{{ old('religion', $student->religion) }}"></div>
    </div>
</div></div>

<div class="card shadow-sm border-0 mb-4"><div class="card-header bg-info text-white"><i class="fas fa-home me-2"></i>Family & Contact</div><div class="card-body">
    <div class="row g-3">
        <div class="col-md-4"><label class="form-label">Father's Name</label><input type="text" name="father_name" class="form-control" value="{{ old('father_name', $student->father_name) }}"></div>
        <div class="col-md-4"><label class="form-label">Mother's Name</label><input type="text" name="mother_name" class="form-control" value="{{ old('mother_name', $student->mother_name) }}"></div>
        <div class="col-md-4"><label class="form-label">Guardian Name</label><input type="text" name="guardian_name" class="form-control" value="{{ old('guardian_name', $student->guardian_name) }}"></div>
        <div class="col-md-4"><label class="form-label">Guardian Phone</label><input type="text" name="guardian_phone" class="form-control" value="{{ old('guardian_phone', $student->guardian_phone) }}"></div>
        <div class="col-md-4"><label class="form-label">Emergency Contact</label><input type="text" name="emergency_contact" class="form-control" value="{{ old('emergency_contact', $student->emergency_contact) }}"></div>
        <div class="col-md-4"><label class="form-label">Address</label><textarea name="address" class="form-control" rows="1">{{ old('address', $student->address) }}</textarea></div>
    </div>
</div></div>

<div class="card shadow-sm border-0 mb-4"><div class="card-header bg-success text-white"><i class="fas fa-graduation-cap me-2"></i>Academic Info</div><div class="card-body">
    <div class="row g-3">
        <div class="col-md-3"><label class="form-label">Class *</label><select name="class_id" id="classSelect" class="form-select" required onchange="filterSections()"><option value="">Select Class</option>@foreach($classes as $c)<option value="{{ $c->id }}" {{ $student->class_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select></div>
        <div class="col-md-3"><label class="form-label">Shift *</label><select name="section_id" id="sectionSelect" class="form-select" required><option value="">Select Shift</option>@foreach($sections as $s)<option value="{{ $s->id }}" data-class-id="{{ $s->class_id }}" {{ $student->section_id == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach</select></div>
        <div class="col-md-3"><label class="form-label">Roll</label><input type="text" name="roll" class="form-control" value="{{ old('roll', $student->roll) }}"></div>
        <div class="col-md-3"><label class="form-label">Registration #</label><input type="text" name="registration_number" class="form-control" value="{{ old('registration_number', $student->registration_number) }}"></div>
        <div class="col-md-3"><label class="form-label">Status</label><select name="status" class="form-select"><option value="active" {{ $student->status == 'active' ? 'selected' : '' }}>Active</option><option value="inactive" {{ $student->status == 'inactive' ? 'selected' : '' }}>Inactive</option><option value="graduated" {{ $student->status == 'graduated' ? 'selected' : '' }}>Graduated</option></select></div>
    </div>
</div></div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save me-2"></i>Update Student</button>
    <a href="{{ route('admin.students.index') }}" class="btn btn-secondary btn-lg">Cancel</a>
</div>
</form>

<script>
function filterSections() {
    const classSelect = document.getElementById('classSelect');
    const sectionSelect = document.getElementById('sectionSelect');
    const selectedClassId = classSelect.value;
    
    // Get all section options
    const options = sectionSelect.querySelectorAll('option');
    
    options.forEach(option => {
        if (option.value === '') {
            option.style.display = 'block'; // Always show placeholder
        } else {
            const classId = option.getAttribute('data-class-id');
            option.style.display = (classId === selectedClassId) ? 'block' : 'none';
        }
    });
    
    // Reset section if currently selected one is hidden
    const currentOption = sectionSelect.querySelector('option[value="' + sectionSelect.value + '"]');
    if (currentOption && currentOption.style.display === 'none') {
        sectionSelect.value = '';
    }
}

// Filter on page load
document.addEventListener('DOMContentLoaded', filterSections);
</script>
@endsection
