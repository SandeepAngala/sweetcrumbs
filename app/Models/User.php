<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'avatar', 'role',
        'loyalty_points', 'google_id', 'address', 'is_blocked', 'blocked_at',
        'notification_preferences', 'uuid',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'loyalty_points' => 'integer',
            'is_blocked' => 'boolean',
            'blocked_at' => 'datetime',
            'notification_preferences' => 'array',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (User $user) {
            if (empty($user->uuid)) {
                $user->uuid = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'super_admin'], true)
            || $this->hasRole('admin')
            || $this->hasRole('super_admin');
    }

    public function isStaff(): bool
    {
        return $this->isAdmin() || $this->role === 'staff' || $this->hasRole('staff');
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer' || $this->role === 'user' || $this->hasRole('customer');
    }

    public function isBlocked(): bool
    {
        return (bool) $this->is_blocked;
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole(string $slug): bool
    {
        return $this->roles()->where('slug', $slug)->exists();
    }

    public function hasPermission(string $slug): bool
    {
        return $this->roles()
            ->whereHas('permissions', fn ($q) => $q->where('slug', $slug))
            ->exists();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function cartSession(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(CartSession::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'author_id');
    }

    public function savedPaymentMethods(): HasMany
    {
        return $this->hasMany(SavedPaymentMethod::class);
    }

    public function bakeryNotifications(): HasMany
    {
        return $this->hasMany(BakeryNotification::class);
    }
}
