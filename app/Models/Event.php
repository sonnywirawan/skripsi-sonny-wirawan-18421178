<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Pendaftaran;

class Event extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'event';
    protected $fillable = [
        'name',
        'registration_start_date',
        'registration_end_date',
        'start_date',
        'end_date',
        'lokasi',
        'limit'
    ];

    public function pendaftaran() {
        return $this->hasMany(Pendaftaran::class);
    }
}
