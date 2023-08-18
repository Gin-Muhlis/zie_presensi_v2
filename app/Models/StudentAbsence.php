<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentAbsence extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'presence_id',
        'date',
        'time',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'student_absences';

    protected $casts = [
        'date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function presence()
    {
        return $this->belongsTo(Presence::class);
    }
}
