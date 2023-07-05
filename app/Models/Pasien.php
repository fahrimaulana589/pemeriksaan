<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class Pasien extends Model
{
    use Filterable, AsSource, Chartable, HasFactory;

    protected $table = 'pasien';

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
    protected $fillable = [
        'nama',
        'icon',
        'gender',
        'harlah',
        'desa',
        'kecamatan',
        'kabupaten_kota'
    ];

    public function pemeriksaans (){
        return $this->hasMany(Pemeriksaan::class);
    }

}
