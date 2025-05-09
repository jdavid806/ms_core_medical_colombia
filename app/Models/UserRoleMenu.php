<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoleMenu extends Model
{
    protected $fillable = [
        'user_role_id',
        'menu_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function userRole()
    {
        return $this->belongsTo(UserRole::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
