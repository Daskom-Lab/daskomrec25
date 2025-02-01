<?php
// app/Models/Announcement.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;


    protected $fillable = [
        'stage_id',
        'success_message',
        'fail_message',
        'link',
    ];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
