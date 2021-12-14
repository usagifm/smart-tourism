@extends('layouts.app')

@section('title')
    Dashboard - Smart Tourism
@endsection

{{-- @dd($vehicles) --}}

@section('custom_styles')
    <style>
        #map {
            height: 700px;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

    </style>
    <script>
        let map;

        const AREA_BOUNDS = {
            north: -4.169996,
            south: -4.883875,
            west: 104.789876,
            east: 105.590504,
        };

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: -4.545524,
                    lng: 105.090552
                },
                minZoom: 10,
                zoom: 10,
                streetViewControl: false,
                mapTypeId: 'hybrid',
                mapTypeControl: false,
                restriction: {
                    latLngBounds: AREA_BOUNDS,
                    strictBounds: true,
                },
            });
        }
    </script>
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->
@endsection

@section('custom_scripts')
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcFHfVyWdI8H1YG67kyUup7VRq1P_fTOE&callback=initMap">
    </script>
@endsection
