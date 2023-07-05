<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class Jadwal extends Model
{
    use Filterable, AsSource, Chartable, HasFactory;

    protected $table = 'jadwals';

    protected $fillable = [
        'dokter_id',
        'senin',
        "start_senin",
        "end_senin",
        'selasa',
        "start_selasa",
        "end_selasa",
        'rabu',
        "start_rabu",
        "end_rabu",
        'kamis',
        "start_kamis",
        "end_kamis",
        'jumat',
        "start_jumat",
        "end_jumat",
        'sabtu',
        "start_sabtu",
        "end_sabtu",
        'minggu',
        "start_minggu",
        "end_minggu"
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class,'dokter_id');
    }

    protected function startSenin(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                return isset($value) ? Carbon::make($value)->format('H:i') : '';
            },
        );
    }

    protected function endSenin(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                return isset($value) ? Carbon::make($value)->format('H:i') : '';
            },
        );
    }
    protected function startSelasa(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                return isset($value) ? Carbon::make($value)->format('H:i') : '';
            },
        );
    }
    protected function endSelasa(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                return isset($value) ? Carbon::make($value)->format('H:i') : '';
            },
        );
    }
    protected function startRabu(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                return isset($value) ? Carbon::make($value)->format('H:i') : '';
            },
        );
    }
    protected function endRabu(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                return isset($value) ? Carbon::make($value)->format('H:i') : '';
            },
        );
    }

    protected function startKamis(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                return isset($value) ? Carbon::make($value)->format('H:i') : '';
            },
        );
    }
    protected function endKamis(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                return isset($value) ? Carbon::make($value)->format('H:i') : '';
            },
        );
    }
    protected function startJumat(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                return isset($value) ? Carbon::make($value)->format('H:i') : '';
            },
        );
    }
    protected function endJumat(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                return isset($value) ? Carbon::make($value)->format('H:i') : '';
            },
        );
    }
    protected function startSabtu(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                return isset($value) ? Carbon::make($value)->format('H:i') : '';
            },
        );
    }
    protected function endSabtu(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                return isset($value) ? Carbon::make($value)->format('H:i') : '';
            },
        );
    }

    protected function startMinggu(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                return isset($value) ? Carbon::make($value)->format('H:i') : '';
            },
        );
    }
    protected function endMinggu(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                return isset($value) ? Carbon::make($value)->format('H:i') : '';
            },
        );
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
