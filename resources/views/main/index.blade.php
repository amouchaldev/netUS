@extends('master')

@section('content')
<div class="row">
  <div class="col-12">

    <x-tabs latest="/" popular="/popular" :tab="$tab"></x-tabs>
    
    <div class="row">

      <div class="col-12 col-lg-8" id="posts">

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

          <div class="alert-alert-info">
            You Should Follow Some Communities To Get Some Intersting Posts
          </div>
          @endforelse
          {{ $posts->links('pagination::bootstrap-5') }}
      </div>
      
      <div class="col-12 col-lg-4">
            @include('layouts.communities')
      </div>
      
      </div>
  </div>
</div>
@endsection

@section('javascripts')
{{-- sweet alert library --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  _socket()
  // follow
  let follow = document.querySelectorAll('.follow')
  follow.forEach(community => {
    community.addEventListener('click', followCommunity)
  })
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