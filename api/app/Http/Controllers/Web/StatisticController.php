<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class StatisticController extends Controller
{
    public function rent()
    {
        $chart_options = [
            'chart_title' => 'Total Penyewaan Kendaraan',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\invoice',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'aggregate_field' => 'total_charge',
            'chart_type' => 'line',
            'filter_period' => 'month',
            'continuous_time' => true,
        ];

        $chart = new LaravelChart($chart_options);

        return view('statistic.index', compact('chart'));
    }

    public function revenue()
    {
        $chart_options = [
            'chart_title' => 'Total Pendapatan',
            'name' => 'Grafik Pendapatan',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\invoice',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'total_charge',
            'chart_type' => 'line',
            'filter_period' => 'month',
            'continuous_time' => true,
        ];

        $chart = new LaravelChart($chart_options);

        return view('statistic.revenue', compact('chart'));
    }
}
