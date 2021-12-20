@extends('layouts.guest')

@section('content')
    <!-- Outer Row -->
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Buat Akun</h1>
                        </div>
                        <form class="user" action="{{ route('register.user.post') }}" method="post">
                            @csrf

                            <div class="form-group">
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="form-control form-control-user @error('name') is-invalid @enderror"
                                    id="exampleInputName" placeholder="{{ __('Name') }}" autofocus required>
                            </div>
                            @error('name')
                                <div class="form-group custom-control">
                                    <label class="">{{ $message }}</label>
                                </div>
                            @enderror

                            <div class="form-group">
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control form-control-user @error('email') is-invalid @enderror"
                                    id="exampleInputEmail" placeholder="{{ __('Email Address') }}" required>
                            </div>
                            @error('email')
                                <div class="form-group custom-control">
                                    <label class="">{{ $message }}</label>
                                </div>
                            @enderror

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" name="password"
                                        class="form-control form-control-user @error('password') is-invalid @enderror"
                                        id="exampleInputPassword" placeholder="{{ __('Password') }}" required>
                                </div>
                                @error('password')
                                    <div class="form-group custom-control">
                                        <label class="">{{ $message }}</label>
                                    </div>
                                @enderror

                                <div class="col-sm-6">
                                    <input type="password" name="password_confirmation"
                                        class="form-control form-control-user @error('password_confirmation') is-invalid @enderror"
                                        id="exampleRepeatPassword" placeholder="{{ __('Konfirmasi Password') }}" required>
                                </div>
                                @error('password_confirmation')
                                    <div class="form-group custom-control">
                                        <label class="">{{ $message }}</label>
                                    </div>
                                @enderror

                            </div>

                            <div class="form-group">
                                <input type="text" name="nik" value="{{ old('nik') }}"
                                    class="form-control form-control-user @error('nik') is-invalid @enderror"
                                    placeholder="{{ __('NIK') }}" required>
                            </div>
                            @error('nik')
                                <div class="form-group custom-control">
                                    <label class="">{{ $message }}</label>
                                </div>
                            @enderror

                            <div class="form-group">
                                <input type="number" name="phone" value="{{ old('phone') }}"
                                    class="form-control form-control-user @error('phone') is-invalid @enderror"
                                    placeholder="{{ __('phone') }}" required>
                            </div>
                            @error('phone')
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
