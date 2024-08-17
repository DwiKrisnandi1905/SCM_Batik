<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rolename()
    {
        $user = Auth::user();
        $role = DB::table('users')
        ->select('users.id AS user_id', 'users.name AS user_name', 'users.email AS user_email', 'roles.id AS role_id', 'roles.name AS role_name')
        ->join('role_user', 'users.id', '=', 'role_user.user_id')
        ->join('roles', 'role_user.role_id', '=', 'roles.id')
        ->where('users.id', $user->id)
        ->get();

        return $role;
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

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    // Method to get all role names
    public function getRoleNames()
    {
        return $this->roles ? $this->roles->pluck('name') : collect();
    }

    // Method to get the first role name
    public function getFirstRole()
    {
        return $this->roles ? $this->roles->first()->name ?? null : null;
    }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

}
