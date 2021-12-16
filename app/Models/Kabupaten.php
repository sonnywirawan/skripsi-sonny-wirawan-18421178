<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Pendaftaran;

class Kabupaten extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'kabupaten';
    protected $fillable = [
        'nama_kabupaten'
    ];

    public function pendaftaran() {
        return $this->hasOne(Pendaftaran::class);
    }
}
