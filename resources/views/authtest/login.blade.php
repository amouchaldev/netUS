@extends('master')
@section('content')
    <div class="row py-5">
        
        <div class="col-lg-6 mx-auto rounded bg-white shadow p-4">
                @if(session()->has('message'))
                    <p class="alert alert-warning">{{ session()->get('message') }}</p>
                @endif  
                <form action="{{ route('auth.login') }}" method="POST" class="w-100">
                    @csrf
                    <h2 class="mb-3">Log in</h2>
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="email" id="" name="email">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="password" id="" name="password">
                    </div>
                    <div class="d-grid ">
                        <button class="btn btn-primary">Log in</button>
                    </div>
                </form>
                
        </div>

    </div>
@endsection