<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Event;

class Pendaftaran extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'pendaftaran';
    protected $fillable = [
        'user_id',
        'event_id',
        'nik',
        'nama_lengkap',
        'no_hp',
        'jk',
        'tempat_lahir',
        'tgl_lahir',
        'alamat',
        'foto_ktp',
        'tgl_daftar',
        'nomor_antrian',
        'jenis_pendaftaran',
        'status_kedatangan',
        'status_keberhasilan_vaksinasi'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function event() {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
