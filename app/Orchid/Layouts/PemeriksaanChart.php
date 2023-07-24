<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Layouts\Chart;

class PemeriksaanChart extends Chart
{
    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'line';

    /**
     * Determines whether to display the export button.
     *
     * @var bool
     */
    protected $export = false;
}
