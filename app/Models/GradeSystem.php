<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeSystem extends Model
{
    protected $fillable = ['grade_name', 'min_marks', 'max_marks', 'gpa'];

    protected $casts = [
        'min_marks' => 'decimal:2',
        'max_marks' => 'decimal:2',
        'gpa' => 'decimal:2',
    ];

    public static function calculateGrade(float $marks): ?array
    {
        $grade = static::where('min_marks', '<=', $marks)
            ->where('max_marks', '>=', $marks)
            ->first();

        return $grade ? ['grade' => $grade->grade_name, 'gpa' => $grade->gpa] : null;
    }
}
