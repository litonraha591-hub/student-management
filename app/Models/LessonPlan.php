<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonPlan extends Model
{
    protected $fillable = [
        'teacher_id', 'subject_id', 'class_id', 'section_id',
        'title', 'description', 'plan_date', 'type', 'academic_year',
    ];

    protected $casts = ['plan_date' => 'date'];

    public function teacher(): BelongsTo { return $this->belongsTo(User::class, 'teacher_id'); }
    public function subject(): BelongsTo { return $this->belongsTo(Subject::class); }
    public function class(): BelongsTo { return $this->belongsTo(ClassModel::class, 'class_id'); }
    public function section(): BelongsTo { return $this->belongsTo(Section::class); }
}
