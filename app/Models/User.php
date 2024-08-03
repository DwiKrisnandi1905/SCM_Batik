<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roleuser()
    {
        return $this->hasOne(RoleUser::class, 'user_id');
    }

    public function hasRole($roleId)
    {
        return $this->roleuser()->where('role_id', $roleId)->exists();
    }

    public function craftsman()
    {
        return $this->hasOne(Craftsman::class, 'user_id');
    }

    public function factory()
    {
        return $this->hasOne(Factory::class, 'user_id');
    }

    public function harvest()
    {
        return $this->hasOne(Harvest::class, 'user_id');
    }

    public function certification()
    {
        return $this->hasOne(Certification::class, 'user_id');
    }

    public function distribution()
    {
        return $this->hasOne(Distribution::class, 'user_id');
    }

    public function monitoring()
    {
        return $this->hasOne(Monitoring::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

}
