<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['email', 'name', 'gender', 'password'];

    protected $searchableFields = ['*'];

    protected $hidden = ['password'];

    public function sessionStarts()
    {
        return $this->hasMany(SessionStart::class);
    }

    public function sessionEnds()
    {
        return $this->hasMany(SessionEnd::class);
    }

    public function studentAbsences()
    {
        return $this->hasMany(StudentAbsence::class);
    }
}
