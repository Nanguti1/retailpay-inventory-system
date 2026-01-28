<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMINISTRATOR = 'administrator';

    public const ROLE_BRANCH_MANAGER = 'branch_manager';

    public const ROLE_STORE_MANAGER = 'store_manager';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'branch_id',
        'store_id',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function isAdministrator(): bool
    {
        return $this->role === self::ROLE_ADMINISTRATOR;
    }

    public function isBranchManager(): bool
    {
        return $this->role === self::ROLE_BRANCH_MANAGER;
    }

    public function isStoreManager(): bool
    {
        return $this->role === self::ROLE_STORE_MANAGER;
    }

    /** Whether this user can complete or cancel transfers (branch manager or administrator only). */
    public function canFacilitateTransfers(): bool
    {
        return $this->isAdministrator() || $this->isBranchManager();
    }

    /** Stores this user is allowed to access (for scoping). */
    public function allowedStoreIds(): array
    {
        if ($this->isAdministrator()) {
            return Store::pluck('id')->all();
        }
        if ($this->isBranchManager() && $this->branch_id) {
            return Store::where('branch_id', $this->branch_id)->pluck('id')->all();
        }
        if ($this->isStoreManager() && $this->store_id) {
            return [$this->store_id];
        }

        return [];
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
            'password' => 'hashed',
        ];
    }
}
