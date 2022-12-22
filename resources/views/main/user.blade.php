@extends('master')

@section('profile')
    <section class="d-flex flex-column align-items-center bg-white p-5">
        <div><img src="{{ asset('storage/' . $user->avatar) }}" alt="" id="profile-photo"></div>
        <h2>{{ $user->name }}</h2>
        <p class="col-md-9 col-lg-6 text-center mb-1">{{ $user->description }}</p>
        <a href="#" class="text-decoration-none d-block mb-2">www.amcdev.me</a>
        <div class="d-flex mb-3"> 
           <small class="me-3"><i class="fa-regular fa-eye me-1"></i><span>{{ $contentViews }} Content Views</span></small>
           <small><i class="fa-regular fa-calendar me-1"></i><span>member since {{ $user->created_at->diffForHumans() }}</span></small>
        </div>
        <div class="d-flex">
            <a href="/chat/{{ $user->id }}" class="btn btn-primary btn-sm me-2"><i class="fa-solid fa-envelope me-1"></i>contact me</a>
            {{-- <a href="#" class="btn btn-primary btn-sm"><i class="fa-solid fa-user-plus me-1"></i>add friend</a> --}}
        </div>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            {{-- @include('layouts.tabs') --}}
            <div class="posts">
                @forelse($posts as $post)
                <x-post-card type="post" :post="$post"></x-post-card>
                @empty 
                <p class="alert alert-info">No Posts</p>
                @endforelse
            </div>
            @if($user->posts_count > 7) 
                <button class="d-block mx-auto btn btn-light">show more</button>
            @endif
        </div>
    </div>
@endsection