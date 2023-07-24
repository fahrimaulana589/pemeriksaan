<?php

namespace App\Orchid\Layouts;

use Illuminate\Support\Carbon;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class PemeriksaanTahun extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        $currentYear = Carbon::now()->year;

// Buat daftar sepuluh tahun terakhir dari tahun ini
        $lastTenYears = [];
        for ($i = 0; $i < 10; $i++) {
            $lastTenYears[$currentYear - $i] = $currentYear - $i;
        }

        return [
            Select::make('tahun')
                ->options($lastTenYears),
        ];
    }
}
