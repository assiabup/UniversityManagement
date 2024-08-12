<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use App\Models\Level;
use App\Models\Module;
use App\Models\FieldOfStudy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }







    public function modules()
    {
        return $this->belongsToMany(Module::class, 'module_teacher', 'teacher_id', 'module_id');
    }

    public function fieldsOfStudy()
    {
        return $this->belongsToMany(FieldOfStudy::class, 'field_of_study_teacher', 'teacher_id', 'field_of_study_id');
    }


    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }
    public function taughtLevels()
    {
        return $this->belongsToMany(Level::class, 'level_teacher', 'teacher_id', 'level_id');
    }
    public function student()
    {
        return $this->hasOne(Student::class);
    }
    public function isProfessor()
    {
        return $this->role === 2;
    }
    ////////////pour la securité///////////////////
    public function isAdmin()
    {
        return $this->role === 1;
    }

    public function isProf()
    {
        return $this->role === 2;
    }

    public function isStudent()
    {
        return $this->role === 0;
    }
    public function notifications()
    {
        return $this->belongsToMany(UserNotification::class, 'user_notification', 'user_id', 'notification_id');
    }
}