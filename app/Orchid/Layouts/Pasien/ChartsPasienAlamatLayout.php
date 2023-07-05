<?php

namespace App\Orchid\Layouts\Pasien;

use Orchid\Screen\Layouts\Chart;

class ChartsPasienAlamatLayout extends Chart
{
    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'pie';

    /**
     * Height of the chart.
     *
     * @var int
     */
    protected $height = 500;
}
