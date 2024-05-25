<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    public $timestamps = false;

    public function position() {
        return $this->belongsTo(Position::class);
    }
    public function getEmailForVerification()
    {
        return null;
    }

    public function hasVerifiedEmail()
    {
        return true; // Always return true to skip email verification
    }

    public function markEmailAsVerified()
    {
        return true; // Always return true to skip marking email as verified
    }

    public function sendEmailVerificationNotification()
    {
        // No action needed as email verification is disabled
    }
}
