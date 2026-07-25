<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamSchedule extends Model
{
    protected $fillable = ['exam_id', 'subject_id', 'class_id', 'exam_date', 'start_time', 'end_time', 'hall'];

    protected $casts = ['exam_date' => 'date'];

    public function exam(): BelongsTo { return $this->belongsTo(Exam::class); }
    public function subject(): BelongsTo { return $this->belongsTo(Subject::class); }
    public function class(): BelongsTo { return $this->belongsTo(ClassModel::class, 'class_id'); }
}
