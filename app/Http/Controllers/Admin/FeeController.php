<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\ClassModel;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\Student;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index()
    {
        $fees = Fee::with('class', 'academicYear')->latest()->get();
        $classes = ClassModel::all();
        $academicYears = AcademicYear::all();
        return view('admin.fees.index', compact('fees', 'classes', 'academicYears'));
    }

    public function create()
    {
        $classes = ClassModel::all();
        $academicYears = AcademicYear::where('is_current', true)->get();
        return view('admin.fees.create', compact('classes', 'academicYears'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:admission,monthly,exam,other',
            'amount' => 'required|numeric|min:0',
            'class_id' => 'required|exists:classes,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        Fee::create($validated);
        return redirect()->route('admin.fees.index')->with('success', 'Fee structure created successfully.');
    }

    public function payments(Fee $fee)
    {
        $payments = FeePayment::with('student.user')->where('fee_id', $fee->id)->latest()->get();
        return view('admin.fees.payments', compact('fee', 'payments'));
    }

    public function generateInvoice(Request $request)
    {
        $validated = $request->validate([
            'fee_id' => 'required|exists:fees,id',
            'student_id' => 'required|exists:students,id',
        ]);

        $fee = Fee::findOrFail($validated['fee_id']);

        $payment = FeePayment::updateOrCreate(
            ['fee_id' => $validated['fee_id'], 'student_id' => $validated['student_id']],
            [
                'amount_paid' => 0,
                'status' => 'pending',
                'invoice_number' => 'INV-' . str_pad(FeePayment::max('id') + 1, 6, '0', STR_PAD_LEFT),
            ]
        );

        return back()->with('success', 'Invoice generated: ' . $payment->invoice_number);
    }

    public function markPaid(FeePayment $payment)
    {
        $payment->update([
            'amount_paid' => $payment->fee->amount,
            'status' => 'paid',
            'payment_date' => now(),
        ]);

        return back()->with('success', 'Payment marked as paid.');
    }

    public function destroy(Fee $fee)
    {
        $fee->delete();
        return redirect()->route('admin.fees.index')->with('success', 'Fee deleted.');
    }
}
