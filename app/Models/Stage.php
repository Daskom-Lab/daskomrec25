<?php
// app/Models/Stage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ]; // 'Administrasi', 'Tes Tulis dan koding', 'Wawancara', 'TuCil'. 'Teaching' 'Levelling'.

    public function caasStages()
    {
        return $this->hasMany(CaasStage::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }
}
