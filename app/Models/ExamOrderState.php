<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamOrderState extends Model
{
    use HasFactory;

    protected $table = 'exam_order_states';

    protected $fillable = [
        'name',
        'is_active'
    ];

    public function examOrders()
    {
        return $this->hasMany(ExamOrder::class, 'exam_order_state_id');
    }

    //Getters
 

}
