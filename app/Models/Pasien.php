<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
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
        'user_id',
        'kabupaten_kota'
    ];

    public function pemeriksaans()
    {
        return $this->hasMany(Pemeriksaan::class);
    }

    public function user()
    {
        return $this->belongsTo(\Orchid\Platform\Models\User::class);
    }

    protected function umur(): Attribute
    {
        return Attribute::make(get: function ($data, $attr) {
            $birthdate = Carbon::createFromFormat('Y-m-d', $attr['harlah']);

            $currentDate = Carbon::now();

            $age = $currentDate->diffInYears($birthdate);
            return $age;
        });
    }

}
