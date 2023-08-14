<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class Dokter extends Model
{
    use Filterable, AsSource, Chartable, HasFactory;

    protected $table = 'dokter';

    protected $fillable = [
        'user_id',
        'nama',
        'icon',
        'gender',
        'harlah',
        'desa',
        'kecamatan',
        'kabupaten_kota',
        'pendidikan',
        'keahlian',
        'jumlah'
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'dokter_id');
    }

    public function pemeriksaans()
    {
        return $this->hasMany(Pemeriksaan::class);
    }

    public function user()
    {
        return $this->belongsTo(\Orchid\Platform\Models\User::class);
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }


}
