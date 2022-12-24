@extends('master')
@section('content')
<div class="row mt-3">
  <div class="col-12">

    <h2 class="mb-4">Search Result</h2>


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
                @forelse($posts as $post)
                  <x-post-card type="post" :post="$post" :community="$post->community->name"></x-post-card>
                @empty 
                    <p class="text-info h6">No Search Result For {{ $keywords }}</p>
                @endforelse
              {{ $posts->links('pagination::bootstrap-5') }}
              </div>
          </div>
      </div>
      {{-- recommended communities --}}
      <div class="col-lg-4">
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