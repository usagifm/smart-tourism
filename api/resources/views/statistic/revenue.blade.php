@extends('layouts.app')

@section('title')
    Statistik Pendapatan - Smart Tourism
@endsection

@section('custom_styles')
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Grafik Pendapatan</h1>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <h6 class="font-weight-bold text-danger">Grafik Pendapatan</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! $chart->renderHtml() !!}
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection

@section('custom_scripts')
    {!! $chart->renderChartJsLibrary() !!}
    {!! $chart->renderJs() !!}
@endsection
