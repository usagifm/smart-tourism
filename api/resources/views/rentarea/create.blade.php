@extends('layouts.app')

@section('title')
    Area Penyewaan - Smart Tourism
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">Tambah Area Penyewaan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('rentarea.store') }}" method="POST" class="col-4 mx-auto">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                            value="{{ old('name') }}" autofocus required>
                        @error('name')
                            <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="operational_hour">Jam Operasional</label>
                        <input type="text" class="form-control @error('operational_hour') is-invalid @enderror"
                            value="{{ old('operational_hour') }}" name="operational_hour" id="operational_hour" required>
                        @error('operational_hour')
                            <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="origin">Asal</label>
                        <input type="text" class="form-control @error('origin') is-invalid @enderror"
                            value="{{ old('origin') }}" name="origin" id="origin" required>
                        @error('origin')
                            <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="destination">Destinasi</label>
                        <input type="text" class="form-control @error('destination') is-invalid @enderror"
                            value="{{ old('destination') }}" name="destination" id="destination" required>
                        @error('destination')
                            <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tolerance">Toleransi</label>
                        <input type="number" class="form-control @error('tolerance') is-invalid @enderror"
                            value="{{ old('tolerance') }}" name="tolerance" id="tolerance" required>
                        @error('tolerance')
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
