<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRolePermission extends Model
{
    protected $fillable = [
        'user_role_id',
        'user_permission_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function userRole()
    {
        return $this->belongsToMany(UserRole::class, 'user_role_permissions');
    }

    public function userPermission()
    {
        return $this->belongsTo(UserPermission::class);
    }
}
