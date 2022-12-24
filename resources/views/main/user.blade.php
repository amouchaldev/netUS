@extends('master')

@section('profile')
    <section class="d-flex flex-column align-items-center bg-white p-5">
        <div class="mb-3"><img src="{{ $user->deleted_at == null ? asset('storage/' . $user->avatar) : asset('storage/avatar/suspended.jpg') }}" alt="" id="profile-photo"></div>
        <h2>{{ $user->name }}</h2>
        <p class="col-md-9 col-lg-6 text-center mb-3">{{ $user->description }}</p>
        {{-- <a href="#" class="text-decoration-none d-block mb-2">www.amcdev.me</a> --}}
        <div class="d-flex mb-3 text-center">
            <small class="me-3 d-flex align-items-center"><i class="fa-regular fa-eye me-1"></i><span>{{ $contentViews }} Content Views</span></small>
            <small class="me-3 d-flex align-items-center"><i class="fa-regular fa-calendar me-1"></i><span>member since
                    {{ $user->created_at->diffForHumans() }}</span>
            </small>
            @can(['delete', 'restore'], $user)
                <small class="dropdown">
                    <span class="dropdown-toggle ms-2" type="button" id="triggerId" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa-solid fa-gear"></i>
                    </span>
                    <div class="dropdown-menu" aria-labelledby="triggerId">
                        {{-- delete --}}
                        @if (!$user->deleted_at)
                            <form action="{{ route('users.delete', $user->id) }}" method="POST" class="dropdown-item">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="disable" class="border-0 bg-transparent">
                            </form>
                        @endif
                        {{-- restore --}}
                        @if ($user->deleted_at)
                            <form action="{{ route('users.restore', $user->id) }}" method="POST" class="dropdown-item">
                                @csrf
                                <input type="submit" value="restore" class="border-0 bg-transparent">
                            </form>
                        @endif
                    </div>
                </small>
            @endcan
        </div>
        <div class="d-flex">
            <a href="/chat/{{ $user->id }}" 
            class="btn btn-primary btn-sm me-2">
            <i class="fa-solid fa-envelope me-1"></i>contact me</a>
        </div>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            {{-- @include('layouts.tabs') --}}
            <div id="posts">
                  {{-- placeholder loading --}}
                <x-post-placeholder></x-post-placeholder>
                <x-post-placeholder></x-post-placeholder>
                <x-post-placeholder></x-post-placeholder>
                <x-post-placeholder></x-post-placeholder>
                <x-post-placeholder></x-post-placeholder>
                <x-post-placeholder></x-post-placeholder>
                @forelse($posts as $post)
                    <x-post-card type="post" :post="$post"></x-post-card>
                @empty
                    <p class="alert alert-info">No Posts</p>
                @endforelse
          {{ $posts->links('pagination::bootstrap-5') }}
            </div>
            @if ($user->posts_count > 7)
                <button class="d-block mx-auto btn btn-light">show more</button>
            @endif
        </div>
    </div>
@endsection
