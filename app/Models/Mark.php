<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mark extends Model
{
    protected $fillable = [
        'student_id', 'subject_id', 'exam_id', 'class_id', 'section_id',
        'quiz_marks', 'assignment_marks', 'mid_marks', 'final_marks',
        'total_marks', 'gpa', 'grade',
    ];

    protected $casts = [
        'quiz_marks' => 'decimal:2',
        'assignment_marks' => 'decimal:2',
        'mid_marks' => 'decimal:2',
        'final_marks' => 'decimal:2',
        'total_marks' => 'decimal:2',
        'gpa' => 'decimal:2',
    ];

    public function student(): BelongsTo { return $this->belongsTo(Student::class); }
    public function subject(): BelongsTo { return $this->belongsTo(Subject::class); }
    public function exam(): BelongsTo { return $this->belongsTo(Exam::class); }
    public function class(): BelongsTo { return $this->belongsTo(ClassModel::class, 'class_id'); }
    public function section(): BelongsTo { return $this->belongsTo(Section::class); }
}
