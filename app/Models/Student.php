<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\Searchable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasRoles;
    use Notifiable;
    use HasFactory;
    use Searchable;
    use HasApiTokens;

    protected $guard_name = 'web';

    protected $guard = 'student_api';

    protected $fillable = [
        'name',
        'nis',
        'gender',
        'password',
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
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }
}
