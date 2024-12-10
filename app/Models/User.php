<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\Employed;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $fillable = [
        'name',
        'rut',
        'email',
        'password',
        'cellphone',
        'address',
        'first_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'roles_id',
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

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'users_id', 'roles_id');
    }

    public function employed()
    {
        return $this->hasOne(Employed::class, 'users_id');
    }

    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    public function getCellphoneAttribute($value)
    {
        if (!$value) return '';
        
        // Eliminar todo excepto números
        $numbers = preg_replace('/[^0-9]/', '', $value);
        
        // Si es número chileno (9 dígitos)
        if (strlen($numbers) == 9) {
            return substr($numbers, 0, 1) . ' ' . substr($numbers, 1, 4) . ' ' . substr($numbers, 5, 4);
        }
        
        return $value;
    }

    public function setCellphoneAttribute($value)
    {
        // Eliminar todo excepto números al guardar
        $this->attributes['cellphone'] = preg_replace('/[^0-9]/', '', $value);
    }
}
