@extends('layouts.guest')

@section('custom_styles')
    <style>
        .bg-img {
            background-image: url("{{ asset('images/ICT.png') }}");
        }

    </style>
@endsection

@section('content')
    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-img"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Smart Tourism Tubaba</h1>
                                </div>
                                <form action="{{ route('login.user.post') }}" method="post" class="user">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            class="form-control form-control-user @error('email') is-invalid @enderror"
                                            id="exampleInputEmail" aria-describedby="emailHelp"
                                            placeholder="{{ __('Enter Email Address') }}" required autofocus>
                                    </div>
                                    @error('email')
                                        <div class="form-group">
                                            <label class="text-danger">{{ $message }}</label>
                                        </div>
                                    @enderror

                                    <div class="form-group">
                                        <input type="password" name="password"
                                            class="form-control form-control-user @error('password') is-invalid @enderror"
                                            id="exampleInputPassword" placeholder="{{ __('Password') }}" required>
                                    </div>
                                    @error('password')
                                        <div class="form-group custom-control">
                                            <label class="text-danger">{{ $message }}</label>
                                        </div>
                                    @enderror
                                    <button type="submit" class="btn btn-danger btn-user btn-block">
                                        {{ __('Login') }}
                                    </button>
                                </form>
                                <hr>
                                @if (Route::has('register.user'))
                                    <div class="text-center">
                                        Belum punya akun?<a class="small" href="{{ route('register.user') }}">
                                            Daftar</a>
                                    </div>
                                @endif
                                <hr>
                                @if (Route::has('login'))
                                    <div class="text-center">
                                        <a class="small" href="{{ route('login') }}">
                                            Login Admin</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
