<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SessionStart extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['date', 'time', 'teacher_id', 'class_student_id'];

    protected $searchableFields = ['*'];

    protected $table = 'session_starts';

    protected $casts = [
        'date' => 'date',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function classStudent()
    {
        return $this->belongsTo(ClassStudent::class);
    }
}
