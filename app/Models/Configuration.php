<?php
// app/Models/Configuration.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengumuman_on',
        'isi_jadwal_on',
        'role_on',
        'current_stage_id',
    ];

    public function currentStage()
    {
        return $this->belongsTo(Stage::class, 'current_stage_id', 'stage_id');
    }
}
