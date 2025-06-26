<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'classification_id'];

    public function classification()
    {
        return $this->belongsTo(Classification::class);
    }

    public function users()
    {
        // return $this->belongsToMany(User::class, 'user_skills');

        return $this->belongsToMany(User::class, 'user_skills')
                ->using(UserSkill::class)
                ->withPivot('description')
                ->withTimestamps();
    }
}