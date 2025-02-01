<?php
// app/Models/Shift.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $table = 'shifts';

    protected $fillable = [
        'shift_no',
        'date',
        'time_start',
        'time_end',
        'kuota',
    ];

    // Relasi ke Plottingan (pivot)
    public function plottingans()
    {
        return $this->hasMany(Plottingan::class, 'shift_id');
    }
}
