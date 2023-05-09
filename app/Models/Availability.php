<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $fillable = ['coach_id', 'day_of_week', 'start_time', 'end_time'];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
