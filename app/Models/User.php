<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'gender',
        'country_id',
        'role',
        'about_me',
        'image_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
    ];

    protected $appends = ['image_url'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skills')
            ->using(UserSkill::class)
            ->withPivot('description')
            ->withTimestamps();
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'user_languages')
            ->withPivot('level');
    }

    public function fullName()
    {
        return trim("{$this->first_name} {$this->last_name}") ?: '';
    }

    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }

        return $this->gender === 'female'
            ? 'https://cdn-icons-png.flaticon.com/512/4140/4140047.png'
            : 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png';
    }

    public function sentInvitations()
    {
        return $this->hasMany(Invitation::class, 'source_user_id');
    }

    public function receivedInvitations()
    {
        return $this->hasMany(Invitation::class, 'destination_user_id');
    }

    public function profileCompletionPercentage()
    {
        $totalFields = 0;
        $filledFields = 0;

        $personalInfoFields = [
            'first_name',
            'last_name',
            'phone',
            'date_of_birth',
            'gender',
            'country_id',
            'about_me',
        ];

        foreach ($personalInfoFields as $field) {
            $totalFields++;
            if (!empty($this->$field)) {
                $filledFields++;
            }
        }

        $totalFields += 2;
        if ($this->skills()->count() > 0) {
            $filledFields++;
        }
        if ($this->languages()->count() > 0) {
            $filledFields++;
        }

        return $totalFields > 0 ? round(($filledFields / $totalFields) * 100) : 0;
    }

    public function sentReviews()
    {
        return $this->hasMany(Review::class, 'sender_id');
    }

    public function receivedReviews()
    {
        return $this->hasMany(Review::class, 'receved_id');
    }
}
