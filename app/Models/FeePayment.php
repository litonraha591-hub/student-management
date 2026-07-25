<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeePayment extends Model
{
    protected $fillable = ['fee_id', 'student_id', 'amount_paid', 'status', 'payment_date', 'invoice_number'];

    protected $casts = ['amount_paid' => 'decimal:2', 'payment_date' => 'date'];

    public function fee(): BelongsTo { return $this->belongsTo(Fee::class); }
    public function student(): BelongsTo { return $this->belongsTo(Student::class); }
}
