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

      </div>
      
      <div class="col-12 col-lg-4">
            <x-communities :communities="$recommendedCommunities"></x-communities>
      </div>
      
      </div>
  </div>
</div>
@endsection

@section('javascripts')
{{-- sweet alert library --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  let follow = document.querySelectorAll('.follow')
  follow.forEach(community => {
    community.addEventListener('click', followCommunity)
  })

</script>
@endsection