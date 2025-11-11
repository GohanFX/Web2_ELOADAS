<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Driver extends Model
{
    protected $table = 'drivers';

    use HasFactory, Notifiable;

    protected $primaryKey = 'id';

    protected $fillable = ['id', 'name', 'sex', 'birth_date', 'country'];

    public function results(): HasMany {
        return $this->hasMany(Race::class, 'driver_id', 'id');
    }


}
