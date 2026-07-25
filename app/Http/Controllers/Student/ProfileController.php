<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\FeePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $student = $user->student;

        $fees = Fee::where('class_id', $student->class_id)
            ->where('academic_year_id', $student->academic_year_id)
            ->with('payments')
            ->get();

        $months = ['January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'];

        $feeStatus = [];
        foreach ($fees as $fee) {
            $payment = $fee->payments->where('student_id', $student->id)->first();
            $feeStatus[] = [
                'name' => $fee->name,
                'type' => $fee->type,
                'amount' => $fee->amount,
                'paid' => $payment ? $payment->amount_paid : 0,
                'due' => $payment ? $fee->amount - $payment->amount_paid : $fee->amount,
                'status' => $payment ? $payment->status : 'pending',
                'payment_date' => $payment?->payment_date,
                'invoice_number' => $payment?->invoice_number,
            ];
        }

        $totalFees = $fees->sum('amount');
        $totalPaid = $student->feePayments->sum('amount_paid');
        $totalDue = $totalFees - $totalPaid;

        return view('student.profile.edit', compact('student', 'feeStatus', 'totalFees', 'totalPaid', 'totalDue'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;

        $validated = $request->validate([
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:20',
        ]);

        $user->phone = $validated['phone'] ?? $user->phone;
        $user->save();

        $student->update([
            'address' => $validated['address'] ?? $student->address,
            'guardian_name' => $validated['guardian_name'] ?? $student->guardian_name,
            'guardian_phone' => $validated['guardian_phone'] ?? $student->guardian_phone,
        ]);

        return redirect()->route('student.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
