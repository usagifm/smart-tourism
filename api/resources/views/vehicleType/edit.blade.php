@extends('layouts.app')

@section('title')
    Tipe Kendaraan - Smart Tourism
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">Edit Tipe Kendaraan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('vehicleType.update', $vehicleType) }}" method="POST" class="col-4 mx-auto">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="type">Type</label>
                        <input type="text" class="form-control @error('type') is-invalid @enderror" name="type" id="type"
                            value="{{ $vehicleType->type }}" autofocus required>
                        @error('type')
                            <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror"
                            value="{{ $vehicleType->description }}" name="description" id="description" required>
                        @error('description')
                            <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
