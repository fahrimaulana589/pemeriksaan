<?php

namespace App\Orchid\Layouts\Pasien;

use Orchid\Screen\Layouts\Chart;

class ChartsPasienGenderLayout extends Chart
{
    /**
     * Height of the chart.
     *
     * @var int
     */
    protected $height = 400;

    protected $type = 'pie';
}
