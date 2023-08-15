<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'nis',
        'image',
        'gender',
        'passsword',
        'class_student_id',
    ];

    protected $searchableFields = ['*'];

    public function classStudent()
    {
        return $this->belongsTo(ClassStudent::class);
    }

    public function studentAbsences()
    {
        return $this->hasMany(StudentAbsence::class);
    }
}
