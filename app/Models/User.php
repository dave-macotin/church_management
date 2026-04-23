<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'is_approved',
        'MemberID',
    ];

    /**
     * Get the member profile associated with the user.
     */
    public function member()
    {
        return $this->belongsTo(People\Member::class, 'MemberID', 'MemberID');
    }

    /**
     * Ensure the user is linked to a Member record.
     * If not linked, tries to find a member by email or creates a new one.
     */
    public function ensureMemberLinked()
    {
        if ($this->MemberID && $this->member()->exists()) {
            return $this->member;
        }

        // Try to find an existing member by email
        $member = People\Member::where('Email', $this->email)->first();

        // If not found, create a new member record
        if (!$member) {
            $member = People\Member::create([
                'FirstName' => $this->first_name ?? explode(' ', $this->name)[0],
                'LastName'  => $this->last_name ?? (count(explode(' ', $this->name)) > 1 ? explode(' ', $this->name)[1] : ''),
                'Email'     => $this->email,
                'Status'    => 'Active',
            ]);
        }

        // Link the user to the member
        $this->update(['MemberID' => $member->MemberID]);
        
        return $member;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
            'password'          => 'hashed',
            'is_approved'       => 'boolean',
        ];
    }
}