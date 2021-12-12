@extends('layouts.app')

@section('title')
    Admin - Smart Tourism
@endsection

@section('custom_styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">Tambah Admin</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.store') }}" method="POST" class="col-6 mx-auto">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="name" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                            value="{{ old('name') }}" autofocus required>
                        @error('name')
                            <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" name="email" id="email" required>
                        @error('email')
                            <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            value="{{ old('password') }}" name="password" id="password" required>
                        @error('password')
                            <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            value="{{ old('password_confirmation') }}" name="password_confirmation"
                            id="password_confirmation" required>
                        @error('password_confirmation')
                            <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="role" class="form-label required">Role</label>
                        <select class="form-control @error('role') is-invalid @enderror" name="role" id="role" required>
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="1">Superadmin</option>
                            <option value="2">Admin Dispora</option>
                            <option value="3">Admin Dishub</option>
                        </select>
                        @error('role')
                            <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label required">Hak Akses</label>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all" style="border-radius: 0">Pilih Semua</span>
                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">Hapus Pilihan</span>
                        </div>
                        <select class="form-control select2 @error('permissions') is-invalid @enderror" name="permissions[]"
                            id="permissions" multiple required>
                            @foreach ($permissions as $id => $permissions)
                                <option value="{{ $id }}"
                                    {{ in_array($id, old('permissions', [])) ? 'selected' : '' }}>{{ $permissions }}
                                </option>
                            @endforeach
                        </select>
                        @error('permissions')
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

@section('custom_scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select-all').click(function() {
                let $select2 = $(this).parent().siblings('.select2')
                $select2.find('option').prop('selected', 'selected')
                $select2.trigger('change')
            })
            $('.deselect-all').click(function() {
                let $select2 = $(this).parent().siblings('.select2')
                $select2.find('option').prop('selected', '')
                $select2.trigger('change')
            })

            $('.select2').select2()
        });
    </script>
@endsection
