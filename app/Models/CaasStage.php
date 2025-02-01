<?php
// app/Models/CaasStage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaasStage extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'stage_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
