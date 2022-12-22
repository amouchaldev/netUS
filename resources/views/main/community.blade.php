@extends('master')
@section('content')
<div class="row">
  <div class="col-12">
    <section class="d-flex flex-wrap justify-content-between align-items-center">
        <div class="col-lg-8">
            <h1>{{ $communityPosts->name }}</h1>
            <p>{{ $communityPosts->description }}</p>
        </div>
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <button class="btn btn-primary" id="follow" data-community="{{ $communityPosts->id }}">{!! $isFollowing ? 'unfollow' : '<i class="fa-solid fa-plus me-1 fa-sm"></i>follow' !!}</button>
          </div>
    </section>
    <x-tabs 
    :latest="'/community/'.$communityPosts->slug"
    :popular="'/community/'.$communityPosts->slug.'/popular'"
    :tab="$tab" 
    ></x-tabs>
    <div class="row">

      <div class="col-12 col-lg-8">
          <div class="row">
              <div class="col-12" id='posts'>
                {{-- placeholder loading --}}
                <x-post-placeholder></x-post-placeholder>
                <x-post-placeholder></x-post-placeholder>
                <x-post-placeholder></x-post-placeholder>
                <x-post-placeholder></x-post-placeholder>
                <x-post-placeholder></x-post-placeholder>
                <x-post-placeholder></x-post-placeholder>
                @foreach($communityPosts->posts as $post)
                  <x-post-card type="post" :post="$post" :community="$communityPosts->name"></x-post-card>
                @endforeach
              </div>
          </div>
      </div>
      {{-- last commets--}}
      <div class="col-12 col-lg-4">
          @include('layouts.latestComments')
      </div>
      
      </div>
  </div>
</div>

@endsection


@section('javascripts')
{{-- sweet alert library --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    
    const follow = document.getElementById('follow')
    follow.addEventListener('click', followCommunity) 
    // like
const likeArrow = document.querySelectorAll('.like-post')
likeArrow.forEach(arrow => arrow.addEventListener('click', e => {
  _like('post', e.target.parentElement.parentElement.previousElementSibling.value, e.target.nextElementSibling)
}))
const dislikeArrow = document.querySelectorAll('.dislike-post')
dislikeArrow.forEach(arrow => arrow.addEventListener('click', e => {
  _dislike('post', e.target.parentElement.parentElement.previousElementSibling.value, e.target.previousElementSibling)
}))

  </script>

@endsection