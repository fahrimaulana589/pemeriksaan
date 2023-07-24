<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class Pemeriksaan extends Model
{
    use Filterable, AsSource, Chartable, HasFactory;

    protected $table = 'pemeriksaan';

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'keluhan',
        'status',
        'hari'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class,'dokter_id','id');
    }

    public function racikan()
    {
        return $this->hasMany(Racikan::class);
    }
}
