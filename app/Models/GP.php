<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class GP extends Model
{

    use HasFactory, Notifiable;

    protected $table = 'gps';
    protected $fillable = ['date', 'name', 'location'];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }
}
