<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Symfony\Component\HttpFoundation\Response;

class StatisticController extends Controller
{
    public function rent()
    {
        abort_if(Gate::denies('show_statistic_rent_vehicle'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query = request()->query('filter', 'month');

        $chart_options = [
            'chart_title' => 'Total Penyewaan Kendaraan',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\invoice',
            'group_by_field' => 'created_at',
            'group_by_period' => $query == 'month' ? 'day' : 'month',
            'aggregate_function' => 'count',
            'aggregate_field' => 'total_charge',
            'chart_type' => 'line',
            'filter_field' => 'created_at',
            'filter_period' => $query == 'month' ? 'month' : 'year',
            'chart_color' => '112, 42, 45',
            'continuous_time' => $query == 'month' ? true : false
        ];

        $chart = new LaravelChart($chart_options);

        return view('statistic.index', compact('chart'));
    }

    public function revenue()
    {
        abort_if(Gate::denies('show_statistic_revenue'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query = request()->query('filter', 'month');

        $chart_options = [
            'chart_title' => 'Total Pendapatan',
            'name' => 'Grafik Pendapatan',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\invoice',
            'group_by_field' => 'created_at',
            'group_by_period' => $query == 'month' ? 'day' : 'month',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'total_charge',
            'chart_type' => 'line',
            'filter_field' => 'created_at',
            'filter_period' => $query == 'month' ? 'month' : 'year',
            'chart_color' => '112, 42, 45',
            'continuous_time' => $query == 'month' ? true : false
        ];

        $chart = new LaravelChart($chart_options);

        return view('statistic.revenue', compact('chart'));
    }
}
