<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class Obat extends Model
{
    use Filterable, AsSource, Chartable, HasFactory;

    protected $table = 'obats';

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected $fillable = [
        'nama',
        'images',
        'deskripsi',
        'stok',
    ];

    public function racikans()
    {
        return $this->hasMany(Racikan::class);
    }
}
