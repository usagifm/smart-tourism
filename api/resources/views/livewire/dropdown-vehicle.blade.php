<div class="row">
    <form wire:submit.prevent="store" class="col-sm-6 col-lg-6 col-md-4 mx-auto" method="POST">
        @csrf
        <div class="form-group">
            <label for="type">Tipe Kendaraan</label>
            <select wire:model="type" name="type" id="type" class="form-control" required>
                <option value="" selected disabled>Pilih tipe kendaraan</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}" {{ old('type') == $type->id ? 'selected' : '' }}>
                        {{ $type->type }}</option>
                @endforeach
            </select>
            @error('type')
                <div class="alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="vehicle">Kendaraan</label>
            <select wire:model="vehicle" name="vehicle" id="vehicle" class="form-control" required>
                @if ($vehicles->count() == 0)
                    <option value="">Pilih kendaraan</option>
                @endif
                @foreach ($vehicles as $vehicle)
                    <option value="{{ $vehicle->id }}" {{ old('vehicle') == $vehicle->id ? 'selected' : '' }}>
                        {{ $vehicle->serial_number }}
                    </option>
                @endforeach
            </select>
            @error('vehicle')
                <div class="alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-danger float-right">Pinjam</button>
    </form>
</div>
