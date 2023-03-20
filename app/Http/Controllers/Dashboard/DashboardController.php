<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\House;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\View\View;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class DashboardController extends Controller
{

    public function __invoke(Request $request): View
    {
        $vehicles_count = Vehicle::count();
        $houses_count = House::count();
        $pending_vehicles_count = Vehicle::where('status', '=', Status::PENDING)->count();
        $pending_houses_count = House::where('status', '=', Status::PENDING)->count();

        $chart_options1 = [
            'chart_title' => 'Véhicules réservé par mois',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Vehicle',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'conditions' => [
                ['condition' => 'status = "booked"', 'color' => 'black', 'fill' => true],
            ],
            'chart_type' => 'line',
        ];
        $chart1 = new LaravelChart($chart_options1);

        $chart_options2 = [
            'chart_title' => 'Maisons réservé par mois',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\House',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'conditions' => [
                ['condition' => 'status = "booked"', 'color' => 'black', 'fill' => true],
            ],
            'chart_type' => 'line',
        ];
        $chart2 = new LaravelChart($chart_options2);

        return view('pages.dashboard', compact('vehicles_count', ['houses_count', 'pending_vehicles_count', 'pending_houses_count', 'chart1', 'chart2']));
    }
}
