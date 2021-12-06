@extends('layouts.app')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Vehicle Table</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('vehicles.store') }}" method="POST" class="col-4 mx-auto">
                @csrf
                <div class="form-group">
                    <label for="vehicle_type_id">Status</label>
                    <select name="vehicle_type_id" id="vehicle_type_id" class="form-control" required>
                        <option value="" disabled selected>Pilih Tipe Kendaraan</option>
                        @foreach ($vehicleTypes as $vehicleType)
                        <option value="{{$vehicleType->id}}" {{ old('vehicle_type_id')==$vehicleType->id ? 'selected' :
                            '' }}>{{$vehicleType->type}}</option>
                        @endforeach
                    </select>
                    @error('vehicle_type_id')
                    <div class="alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="label">Label</label>
                    <input type="text" class="form-control @error('label') is-invalid @enderror" name="label" id="label"
                        value="{{old('label')}}" autofocus required>
                    @error('label')
                    <div class="alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="serial_number">Serial Number</label>
                    <input type="text" class="form-control @error('serial_number') is-invalid @enderror"
                        value="{{old('serial_number')}}" name="serial_number" id="serial_number" required>
                    @error('serial_number')
                    <div class="alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="fare">Fare</label>
                    <input type="number" class="form-control @error('fare') is-invalid @enderror" name="fare" id="fare"
                        value="{{old('fare')}}" required>
                    @error('fare')
                    <div class="alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror"
                        value="{{old('description')}}" name="description" id="description" required>
                    @error('description')
                    <div class="alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="brand">Brand</label>
                    <input type="text" class="form-control @error('brand') is-invalid @enderror" name="brand" id="brand"
                        value="{{old('brand')}}" required>
                    @error('brand')
                    <div class="alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="is_available">Status</label>
                    <select name="is_available" id="is_available" class="form-control" required>
                        <option value="" disabled selected>Pilih Status</option>
                        <option value="1" {{ old('is_available')=='1' ? 'selected' : '' }}>Tersedia</option>
                        <option value="2" {{ old('is_available')=='2' ? 'selected' : '' }}>Perbaikan</option>
                    </select>
                    @error('is_available')
                    <div class="alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="is_inside">Lokasi</label>
                    <select name="is_inside" id="is_inside" class="form-control" required>
                        <option value="" disabled selected>Pilih Lokasi</option>
                        <option value="1" {{ old('is_inside')=='1' ? 'selected' : '' }}>Didalam</option>
                        <option value="2" {{ old('is_inside')=='2' ? 'selected' : '' }}>Diluar</option>
                    </select>
                    @error('is_inside')
                    <div class="alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="rent_area_id">Area Peminjaman</label>
                    <select name="rent_area_id" id="rent_area_id" class="form-control" required>
                        <option value="" disabled selected>Pilih Area Peminjaman</option>
                        @foreach ($rentAreas as $rentArea)
                        <option value="{{$rentArea->id}}" {{ old('rent_area_id')==$rentArea->id ? 'selected' :
                            '' }}>{{$rentArea->name}}</option>
                        @endforeach
                    </select>
                    @error('rent_area_id')
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
