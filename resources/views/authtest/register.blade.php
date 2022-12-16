@extends('master')
@section('content')
    <div class="row py-5">
        
        <div class="col-lg-6 d-flex align-items-center justify-content-center rounded bg-white shadow p-4">
                
                <form action="{{ route('auth.register') }}" method="POST">
                    @csrf
                    <h2 class="mb-3">Create Account</h2>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="firstName">
                            <input type="text" class="form-control" placeholder="first name" id="" name="firstName">
                            @error('firstName') <small class="text-warning">{{ $message }}</small> @enderror
                        </div>

                        <div class="lastName">
                            <input type="text" class="form-control" placeholder="last name" id="" name="lastName">
                            @error('lastName') <small class="text-warning">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="email" id="" name="email">
                        @error('email') <small class="text-warning">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="password" id="" name="password">
                        @error('password') <small class="text-warning">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="confirm password" id="" name="password_confirmation">
                        {{-- @error('password_confirmation') <small class="text-warning">{{ $message }}</small> @enderror --}}
                    </div>
                    <div class="d-grid ">
                        <button class="btn btn-primary">Sign up</button>
                    </div>
                </form>
                
        </div>

        <div class="col-lg-6 d-none d-lg-flex align-items-center">
            <img src="{{ asset('assets/img/header-illustration-reduced@2x.png') }}" alt="" class="w-100 rounded">
        </div>
    </div>
@endsection