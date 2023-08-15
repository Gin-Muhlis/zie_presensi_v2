<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassStudent extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'code'];

    protected $searchableFields = ['*'];

    protected $table = 'class_students';

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function sessionStarts()
    {
        return $this->hasMany(SessionStart::class);
    }

    public function sessionEnds()
    {
        return $this->hasMany(SessionEnd::class);
    }
}
