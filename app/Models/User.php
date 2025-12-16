<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'username',
        'phone',
        'role',
        'password',
        'avatar',           // Tambahkan ini
        'avatar_disk',      // Tambahkan ini
        'avatar_updated_at', // Tambahkan ini
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'avatar_updated_at' => 'datetime', // Tambahkan ini
    ];

    // Accessor untuk URL avatar lengkap
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && Storage::disk($this->avatar_disk ?: 'public')->exists('avatars/' . $this->avatar)) {
            return asset('storage/avatars/' . $this->avatar);
        }
        
        return $this->getDefaultAvatarUrl();
    }

    // Accessor untuk thumbnail avatar (ukuran kecil)
    public function getAvatarThumbnailUrlAttribute(): string
    {
        return $this->avatar_url; // Bisa dikembangkan untuk thumbnail
    }

    // Accessor untuk menampilkan inisial jika tidak ada avatar
    public function getInitialsAttribute(): string
    {
        $nameParts = explode(' ', $this->name);
        $initials = '';
        
        if (count($nameParts) >= 2) {
            $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[count($nameParts) - 1], 0, 1));
        } else {
            $initials = strtoupper(substr($this->name, 0, 2));
        }
        
        return $initials;
    }

    // Accessor untuk warna background avatar default
    public function getAvatarColorAttribute(): string
    {
        // Generate warna konsisten berdasarkan nama user
        $hash = md5($this->name);
        return '#' . substr($hash, 0, 6);
    }

    // Method untuk mendapatkan URL avatar default
    public function getDefaultAvatarUrl(): string
    {
        $defaultAvatars = [
            asset('images/default-avatar.png'),
            'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=FFFFFF&background=' . substr($this->avatar_color, 1),
            'https://api.dicebear.com/7.x/initials/svg?seed=' . urlencode($this->name) . '&backgroundColor=' . substr($this->avatar_color, 1),
        ];
        
        return $defaultAvatars[0]; // Gunakan yang pertama sebagai default
    }

    // Method untuk mengecek apakah user memiliki avatar
    public function hasAvatar(): bool
    {
        return !empty($this->avatar);
    }

    // Method untuk menghapus avatar
    public function deleteAvatar(): bool
    {
        if ($this->hasAvatar()) {
            Storage::disk($this->avatar_disk ?: 'public')->delete('avatars/' . $this->avatar);
            
            $this->avatar = null;
            $this->avatar_updated_at = now();
            return $this->save();
        }
        
        return false;
    }

    // Method untuk mengupdate avatar
    public function updateAvatar(string $filename): bool
    {
        // Hapus avatar lama jika ada
        $this->deleteAvatar();
        
        $this->avatar = $filename;
        $this->avatar_disk = 'public';
        $this->avatar_updated_at = now();
        
        return $this->save();
    }

    // Method untuk mendapatkan info avatar
    public function getAvatarInfo(): array
    {
        return [
            'has_avatar' => $this->hasAvatar(),
            'avatar_url' => $this->avatar_url,
            'avatar_name' => $this->avatar,
            'avatar_disk' => $this->avatar_disk,
            'last_updated' => $this->avatar_updated_at,
            'default_url' => $this->getDefaultAvatarUrl(),
            'initials' => $this->initials,
            'color' => $this->avatar_color,
        ];
    }

    // Boot method untuk event handling
    protected static function boot()
    {
        parent::boot();

        // Event ketika user dihapus, hapus juga avatar-nya
        static::deleting(function ($user) {
            $user->deleteAvatar();
        });
    }

    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah warga
     */
    public function isWarga(): bool
    {
        return $this->role === 'warga';
    }

    /**
     * Cek apakah user adalah relawan
     */
    public function isRelawan(): bool
    {
        return $this->role === 'relawan';
    }

    /**
     * Cek apakah user adalah petugas
     */
    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    /**
     * Get role display name
     */
    public function getRoleDisplayAttribute(): string
    {
        $roles = [
            'admin' => 'Administrator',
            'warga' => 'Warga',
            'relawan' => 'Relawan',
            'petugas' => 'Petugas',
        ];
        
        return $roles[$this->role] ?? ucfirst($this->role);
    }

    /**
     * Scope untuk admin
     */
    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope untuk warga
     */
    public function scopeWarga($query)
    {
        return $query->where('role', 'warga');
    }

    /**
     * Scope untuk relawan
     */
    public function scopeRelawan($query)
    {
        return $query->where('role', 'relawan');
    }

    /**
     * Scope untuk petugas
     */
    public function scopePetugas($query)
    {
        return $query->where('role', 'petugas');
    }

    /**
     * Scope untuk user yang memiliki avatar
     */
    public function scopeHasAvatar($query)
    {
        return $query->whereNotNull('avatar');
    }

    /**
     * Scope untuk user yang tidak memiliki avatar
     */
    public function scopeNoAvatar($query)
    {
        return $query->whereNull('avatar');
    }

    /**
     * Scope untuk mencari berdasarkan role dan nama
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('username', 'like', "%{$search}%");
        });
    }

    /**
     * Get user display name (nama + role)
     */
    public function getDisplayNameAttribute(): string
    {
        return "{$this->name} ({$this->getRoleDisplayAttribute()})";
    }

    /**
     * Get last avatar update in human readable format
     */
    public function getAvatarLastUpdatedAttribute(): string
    {
        if (!$this->avatar_updated_at) {
            return 'Belum pernah diperbarui';
        }
        
        return $this->avatar_updated_at->diffForHumans();
    }

    /**
     * Check if avatar needs update (older than 30 days)
     */
    public function getAvatarNeedsUpdateAttribute(): bool
    {
        if (!$this->avatar_updated_at) {
            return true;
        }
        
        return $this->avatar_updated_at->diffInDays(now()) > 30;
    }

    /**
     * Get user statistics
     */
    public function getStatsAttribute(): array
    {
        return [
            'total_donasi' => 0, // Bisa dihubungkan dengan model Donasi jika ada
            'total_bencana' => 0, // Bisa dihubungkan dengan model Bencana jika ada
            'total_aktivitas' => 0, // Bisa dihubungkan dengan model Aktivitas jika ada
        ];
    }
}