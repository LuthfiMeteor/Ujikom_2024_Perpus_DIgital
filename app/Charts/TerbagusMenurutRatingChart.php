<?php

namespace App\Charts;

use App\Models\BukuModel;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class TerbagusMenurutRatingChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build()
    {
        $topBooks = BukuModel::orderBy('rating', 'desc')->take(5)->get(); // Retrieving top 5 books ordered by rating

        // Extracting titles and ratings for chart data
        $titles = $topBooks->pluck('judul')->toArray();
        $ratings = $topBooks->pluck('rating')->toArray();

        // Assigning the chart to the class property
        $this->chart = (new LarapexChart)->barChart()
            ->setTitle('Top Buku')
            ->setSubtitle('Bedasarkan Rating')
            ->addData('Rating', $ratings)
            ->setXAxis($titles);

        return $this->chart;
    }
}
