<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSpecialtyMenu extends Model
{
    protected $fillable = [
        'user_specialty_id',
        'menu_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function userSpecialty()
    {
        return $this->belongsTo(UserSpecialty::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
