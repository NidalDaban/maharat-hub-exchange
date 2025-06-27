<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'last_message_at'];

    // public function users()
    // {
    //     return $this->belongsToMany(User::class)
    //         ->withPivot('is_active', 'left_at')
    //         ->withTimestamps();
    // }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['body', 'is_active', 'left_at', 'read_at', 'created_at', 'updated_at']);
            // ->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function otherUser()
    {
        return $this->users()->where('user_id', '!=', auth()->id());
    }
}
