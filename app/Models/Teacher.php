<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\Searchable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use HasRoles;
    use Notifiable;
    use HasFactory;
    use Searchable;
    use HasApiTokens;

    protected $guard_name = 'web';

    protected $guard = 'teacher_api';

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
