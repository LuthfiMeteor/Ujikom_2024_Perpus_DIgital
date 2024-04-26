<?php

namespace App\Http\Controllers;

use App\Charts\MemberChart;
use App\Charts\MemberRegistrationChart;
use App\Charts\TerbagusMenurutRatingChart;
use App\Models\MemberModel;
use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(MemberChart $chart, TerbagusMenurutRatingChart $rating)
    {
        return view('dashboard.pages.home', ['chart' => $chart->build(), 'rating' => $rating->build()]);
    }
}
