<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Ramsey\Uuid\Uuid;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type'
    ];

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
            'password' => 'hashed',
            'user_type' => 'string',
        ];
    }

    public function employer()
    {
        return $this->hasOne(Employer::class);
    }

    public function candidate()
    {
        return $this->hasOne(Candidate::class);
    }

    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }

    public function isEmployer(): bool
    {
        return $this->user_type === 'employer';
    }

    public function isCandidate(): bool
    {
        return $this->user_type === 'candidate';
    }

    public function newUniqueId(): string
    {
        return (string) Uuid::uuid4();
    }

    public function jobs()
    {
        return $this->hasManyThrough(
            Job::class,
            Employer::class,
            'user_id',
            'employer_id',
            'id',
            'id'
        );
    }

    
}
