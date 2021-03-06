@extends('layouts.app')

@section('title')
    Tipe Kendaraan - Smart Tourism
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">Tambah Tipe Kendaraan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('vehicleType.store') }}" method="POST" class="col-sm-6 col-lg-4 col-md-6 mx-auto">
                    @csrf
                    <div class="form-group">
                        <label for="type">Type</label>
                        <input type="text" class="form-control @error('type') is-invalid @enderror" name="type" id="type"
                            value="{{ old('type') }}" autofocus required>
                        @error('type')
                            <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror"
                            value="{{ old('description') }}" name="description" id="description" required>
                        @error('description')
                            <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-danger float-right">Submit</button>
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
