@extends('layouts.customer')

@section('title')
    Sewa Kendaraan - Smart Tourism
@endsection

@section('custom_styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/table/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Menunggu</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countVehicle['waiting'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-pause-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Berjalan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countVehicle['ongoing'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-motorcycle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Selesai</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countVehicle['ended'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Dibayar</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countVehicle['paid'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-money-bill fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">Sewa Kendaraan</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <form action="{{ route('vehicle.rent.post') }}" class="col-sm-6 col-lg-6 col-md-4 mx-auto"
                        method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="vehicle_id">Kendaraan</label>
                            <select name="vehicle_id" id="vehicle_id" class="form-control select2" required>
                                @foreach ($vehicles as $id => $vehicle)
                                    <option value="{{ $id }}" {{ old('vehicle_id') == $id ? 'selected' : '' }}
                                        @if ($loop->index == 0) selected disabled @endif>
                                        {{ $vehicle }}</option>
                                @endforeach
                            </select>
                            @error('vehicle_id')
                                <div class="alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-danger float-right">Pinjam</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">Dalam Penyewaan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="example1" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>No Serial</th>
                                <th>Biaya</th>
                                <th>Waktu</th>
                                <th>Total</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rentals as $rental)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $rental->vehicle->serial_number }}</td>
                                    <td>Rp. {{ number_format($rental->vehicle->fare, 2) }} / 30 <sub>menit</sub></td>
                                    <td>{{ $rental->total_time }} <sub>menit</sub></td>
                                    <td>Rp. {{ number_format($rental->price, 2) }}</td>
                                    <td>{{ $rental->date_time_start ? $rental->date_time_start->format('h:i d-m-Y') : '-' }}
                                    </td>
                                    <td>{{ $rental->date_time_end ? $rental->date_time_end->format('h:i d-m-Y') : '-' }}
                                    </td>
                                    <td>{{ ucfirst($rental->status) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection

@section('custom_scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2()
        });
    </script>
    <script src="{{ asset('js/table/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/table/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/table/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/table/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/table/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/table/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/table/jszip.min.js') }}"></script>
    <script src="{{ asset('js/table/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/table/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/table/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/table/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/table/buttons.colVis.min.js') }}"></script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "order": [],
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ['copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5', "colvis"
                ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
