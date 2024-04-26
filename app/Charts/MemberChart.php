<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Member;
use App\Models\MemberModel;
use Carbon\Carbon;

class MemberChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now();

        $dates = [];
        $counts = [];

        // Mengambil data member untuk rentang tanggal yang ditentukan
        $members = MemberModel::whereBetween('created_at', [$startDate, $endDate])->get();

        // Loop untuk setiap hari dalam rentang tanggal
        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $formattedDate = $date->format('Y-m-d');
            $memberCount = $members->filter(function ($member) use ($formattedDate) {
                return substr($member->created_at, 0, 10) === $formattedDate;
            })->count();

            // Tambahkan tanggal dan jumlah ke array
            $dates[] = $formattedDate;
            $counts[] = $memberCount;
        }

        return $this->chart->lineChart()
            ->setTitle('Chart Pendaftar Member')
            ->setXAxis(['categories' => $dates])
            ->setDataset([['name' => 'Jumlah Member', 'data' => $counts]]);
    }
}
