<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Pendaftaran;

class Pekerjaan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'pekerjaan';
    protected $fillable = [
        'nama'
    ];

    public function pendaftaran() {
        return $this->hasOne(Pendaftaran::class);
    }
}
