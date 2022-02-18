@extends('layouts.guest')

@section('content')
    <!-- Outer Row -->
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image">
                    <div class="d-flex justify-content-between">
                        <img src="{{ asset('images/logo_tubaba.png') }}" alt="" width="45px" height="60px"
                            class="m-2">
                        <img src="{{ asset('images/TubabaPutih.png') }}" alt="" width="160px" height="90px"
                            class="m-2">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h2 text-dark mb-4">Smart Tourism</h1>
                            <h4 class="h4 text-gray-900 mb-4">Buat Akun</h4>
                        </div>
                        <form class="user" action="{{ route('register.user.post') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="name" class="text-dark">Nama</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror" id="exampleInputName"
                                    placeholder="{{ __('Nama') }}" autofocus required autocomplete="off">
                            </div>
                            @error('name')
                                <div class="form-group custom-control">
                                    <label class="">{{ $message }}</label>
                                </div>
                            @enderror

                            <div class="form-group">
                                <label for="email" class="text-dark">Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail"
                                    placeholder="{{ __('Alamat Email') }}" required autocomplete="off">
                            </div>
                            @error('email')
                                <div class="form-group custom-control">
                                    <label class="">{{ $message }}</label>
                                </div>
                            @enderror

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="password" class="text-dark">Password</label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        id="exampleInputPassword" placeholder="{{ __('Password') }}" required>
                                    @error('password')
                                        <div class="form-group custom-control">
                                            <label class="">{{ $message }}</label>
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label for="password" class="text-dark">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="exampleRepeatPassword" placeholder="{{ __('Konfirmasi Password') }}"
                                        required>
                                    @error('password_confirmation')
                                        <div class="form-group custom-control">
                                            <label class="">{{ $message }}</label>
                                        </div>
                                    @enderror
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="nik" class="text-dark">NIK</label>
                                <input type="text" name="nik" value="{{ old('nik') }}"
                                    class="form-control @error('nik') is-invalid @enderror"
                                    placeholder="{{ __('NIK') }}" required autocomplete="off">
                            </div>
                            @error('nik')
                                <div class="form-group custom-control">
                                    <label class="">{{ $message }}</label>
                                </div>
                            @enderror

                            <div class="form-group">
                                <label for="phone" class="text-dark">No Telepon</label>
                                <input type="number" name="phone" value="{{ old('phone') }}"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="{{ __('No Telepon') }}" required autocomplete="off">
                            </div>
                            @error('phone')
                                <div class="form-group custom-control">
                                    <label class="">{{ $message }}</label>
                                </div>
                            @enderror

                            <div class="form-group">
                                <label for="ktp" class="text-dark">KTP</label>
                                <input type="file" name="ktp" value="{{ old('ktp') }}"
                                    class="form-control @error('ktp') is-invalid @enderror"
                                    placeholder="{{ __('KTP') }}" required autocomplete="off">
                            </div>
                            @error('ktp')
                                <div class="form-group custom-control">
                                    <label class="">{{ $message }}</label>
                                </div>
                            @enderror

                            <button type="submit" class="btn btn-danger btn-user btn-block">
                                {{ __('Register Account') }}
                            </button>
                        </form>
                        <hr>
                        @if (Route::has('login.user'))
                            <div class="text-center">
                                <a class="small" href="{{ route('login.user') }}">Sudah punya akun?</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
