@extends('layouts.app')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<div class="row">
    {{-- Student Info Card --}}
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body text-center p-4">
                <img src="{{ $student->user->photo_url }}" alt="{{ $student->user->name }}"
                     class="rounded-circle mb-3" width="100" height="100">
                <h5 class="mb-1">{{ $student->user->name }}</h5>
                <span class="badge bg-primary mb-2">{{ strtoupper($student->student_id) }}</span>
                <p class="text-muted mb-3">{{ $student->class?->name }} - {{ $student->section?->name }}</p>

                <div class="text-start mt-3">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted"><i class="fas fa-user me-2"></i>Roll No</span>
                        <strong>{{ $student->roll }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted"><i class="fas fa-venus-mars me-2"></i>Gender</span>
                        <strong>{{ ucfirst($student->gender) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted"><i class="fas fa-phone me-2"></i>Phone</span>
                        <strong>{{ $student->user->phone ?? 'N/A' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted"><i class="fas fa-envelope me-2"></i>Email</span>
                        <strong>{{ $student->user->email }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted"><i class="fas fa-calendar me-2"></i>Admission</span>
                        <strong>{{ $student->admission_date?->format('M d, Y') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted"><i class="fas fa-user-friends me-2"></i>Father</span>
                        <strong>{{ $student->father_name }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted"><i class="fas fa-home me-2"></i>Address</span>
                        <strong class="text-end" style="max-width: 60%;">{{ $student->address ?? 'N/A' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted"><i class="fas fa-graduation-cap me-2"></i>Academic Year</span>
                        <strong>{{ $student->academicYear?->name }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Fee Payment Status --}}
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-white border-0 p-4">
                <h5 class="mb-0"><i class="fas fa-money-bill-wave me-2 text-primary"></i>Fee Payment Status</h5>
            </div>
            <div class="card-body p-0">
                {{-- Summary Cards --}}
                <div class="row g-0 px-4 pb-3">
                    <div class="col-md-4">
                        <div class="p-3 rounded-3" style="background: #eef2ff;">
                            <div class="text-muted small">Total Fees</div>
                            <h4 class="mb-0 mt-1" style="color: var(--primary);">Rs. {{ number_format($totalFees, 2) }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 ms-2" style="background: #ecfdf5;">
                            <div class="text-muted small">Paid</div>
                            <h4 class="mb-0 mt-1 text-success">Rs. {{ number_format($totalPaid, 2) }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 ms-2" style="background: #fef2f2;">
                            <div class="text-muted small">Due</div>
                            <h4 class="mb-0 mt-1 text-danger">Rs. {{ number_format($totalDue, 2) }}</h4>
                        </div>
                    </div>
                </div>

                {{-- Fee Table --}}
                @if(count($feeStatus) > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: #f8fafc;">
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Fee Name</th>
                                <th>Type</th>
                                <th class="text-end">Amount</th>
                                <th class="text-end">Paid</th>
                                <th class="text-end">Due</th>
                                <th class="text-center">Status</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feeStatus as $i => $fee)
                            <tr>
                                <td class="ps-4">{{ $i + 1 }}</td>
                                <td><strong>{{ $fee['name'] }}</strong></td>
                                <td><span class="badge bg-light text-dark">{{ ucfirst($fee['type']) }}</span></td>
                                <td class="text-end">Rs. {{ number_format($fee['amount'], 2) }}</td>
                                <td class="text-end text-success">Rs. {{ number_format($fee['paid'], 2) }}</td>
                                <td class="text-end text-danger">Rs. {{ number_format($fee['due'], 2) }}</td>
                                <td class="text-center">
                                    @if($fee['status'] === 'paid')
                                        <span class="badge bg-success"><i class="fas fa-check me-1"></i>Paid</span>
                                    @elseif($fee['status'] === 'partial')
                                        <span class="badge bg-warning text-dark"><i class="fas fa-minus-circle me-1"></i>Partial</span>
                                    @else
                                        <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if($fee['invoice_number'])
                                        <small class="text-muted">{{ $fee['invoice_number'] }}</small>
                                    @else
                                        <small class="text-muted">-</small>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-receipt fa-3x mb-3"></i>
                        <p>No fee records found for your class.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Edit Profile Form --}}
<div class="row mt-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-white border-0 p-4">
                <h5 class="mb-0"><i class="fas fa-edit me-2 text-primary"></i>Edit Profile Information</h5>
            </div>
            <div class="card-body p-4">
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <form method="POST" action="{{ route('student.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', $student->user->phone) }}" placeholder="Enter phone number">
                            @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Guardian Name</label>
                            <input type="text" name="guardian_name" class="form-control @error('guardian_name') is-invalid @enderror"
                                   value="{{ old('guardian_name', $student->guardian_name) }}" placeholder="Enter guardian name">
                            @error('guardian_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Guardian Phone</label>
                            <input type="text" name="guardian_phone" class="form-control @error('guardian_phone') is-invalid @enderror"
                                   value="{{ old('guardian_phone', $student->guardian_phone) }}" placeholder="Enter guardian phone">
                            @error('guardian_phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Address</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                   value="{{ old('address', $student->address) }}" placeholder="Enter address">
                            @error('address')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save Changes</button>
                        <a href="{{ route('student.profile.edit') }}" class="btn btn-secondary"><i class="fas fa-times me-2"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
