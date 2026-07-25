<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assignment extends Model
{
    protected $fillable = ['title', 'description', 'subject_id', 'class_id', 'section_id', 'teacher_id', 'deadline', 'attachment'];

    protected $casts = ['deadline' => 'date'];

    public function subject(): BelongsTo { return $this->belongsTo(Subject::class); }
    public function class(): BelongsTo { return $this->belongsTo(ClassModel::class, 'class_id'); }
    public function section(): BelongsTo { return $this->belongsTo(Section::class); }
    public function teacher(): BelongsTo { return $this->belongsTo(User::class, 'teacher_id'); }
    public function submissions(): HasMany { return $this->hasMany(AssignmentSubmission::class); }
}
