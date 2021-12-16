<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Event;
use App\Models\Kabupaten;
use App\Models\Pekerjaan;

class Pendaftaran extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'pendaftaran';
    protected $fillable = [
        'user_id',
        'event_id',
        'nip',
        'nama_lengkap',
        'no_hp',
        'tempat_lahir',
        'tgl_lahir',
        'jk',
        'pekerjaan_id',
        'pangkat',
        'jabatan',
        'instansi',
        'kabupaten_id',
        'npwp',
        'nama_bank',
        'no_rekening',
        'biaya_perjalanan',
        'status_pendaftaran_ulang',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function event() {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function kabupaten() {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id');
    }

    public function pekerjaan() {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id');
    }
}
