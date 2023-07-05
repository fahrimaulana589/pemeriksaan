<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class Racikan extends Model
{
    use Filterable, AsSource, Chartable, HasFactory;

    protected $table = 'racikan';

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected $fillable = [
        'obat_id',
        'pemeriksaan_id',
        'jumlah'
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class);
    }
}
