<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
class Race extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'races';
    protected $primaryKey = 'id';
    protected $fillable = ['date', 'driver_id', 'placement', 'mistake', 'team', 'type', 'engine'];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
