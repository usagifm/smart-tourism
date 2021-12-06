@extends('layouts.app')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="col my-2">
        <a href="{{ route('vehicles.create') }}" class="btn btn-primary">Tambah Kendaraan</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Vehicle Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Serial Number</th>
                            <th>Fare</th>
                            <th>Description</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehicles as $vehicle)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $vehicle->serial_number }}</td>
                            <td>{{ $vehicle->fare }}</td>
                            <td>{{ $vehicle->description }}</td>
                            <td>
                                <a href="{{route('vehicles.edit', $vehicle)}}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{route('vehicles.destroy', $vehicle)}}" method="POST"
                                    class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return ('Yakin ingin menghapus?')"
                                        class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- {{ $vehicles->links() }} --}}

            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection
