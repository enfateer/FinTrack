<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'profile_picture'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    // Accessor untuk profile picture URL
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return Storage::url($this->profile_picture);
        }
        
        return asset('images/default-avatar.png');
    }

    // Method untuk menghapus profile picture
    public function deleteProfilePicture()
    {
        if ($this->profile_picture && Storage::disk('public')->exists($this->profile_picture)) {
            Storage::disk('public')->delete($this->profile_picture);
        }

        $this->update(['profile_picture' => null]);
    }
}