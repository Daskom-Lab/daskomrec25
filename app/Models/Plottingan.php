<?php
// app/Models/Plottingan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plottingan extends Model
{
    use HasFactory;

    protected $table = 'plottingans';

    protected $fillable = [
        'caas_id',
        'shift_id',
        // 'stage_id', jika ada keknya kan udah cuman interview sama teaching
    ];

    // Relasi ke CAAS
    public function caas()
    {
        return $this->belongsTo(Caas::class, 'caas_id');
    }

    // Relasi ke SHIFT
    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
}

