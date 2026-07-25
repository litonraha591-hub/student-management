<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fee extends Model
{
    protected $fillable = ['name', 'type', 'amount', 'class_id', 'academic_year_id'];

    protected $casts = ['amount' => 'decimal:2'];

    public function class(): BelongsTo { return $this->belongsTo(ClassModel::class, 'class_id'); }
    public function academicYear(): BelongsTo { return $this->belongsTo(AcademicYear::class); }
    public function payments(): HasMany { return $this->hasMany(FeePayment::class); }
}
