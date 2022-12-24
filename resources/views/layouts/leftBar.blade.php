 {{-- offcanvas --}}
 <div class="offcanvas offcanvas-start" tabindex="-1" id="left-bar" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
      <span></span>
      {{-- <h5 class="offcanvas-title" id="offcanvasExampleLabel"><img src="{{ asset('assets/img/logo.png') }}" alt="logo" class="logo"></h5> --}}
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0 text-center">
      <h4 class="mb-3 mt-5"><i class="fa-regular fa-paper-plane me-3"></i>Communities</h4>
      {{-- <div class="mb-3  px-3">
        Some text as placeholder. In real life you can have the elements you have chosen. Like, text, images, lists, etc.
      </div> --}}
    <ul class="list-unstyled " id="communities-list">
        @foreach($communities as $community)
            <li class="mb-1 py-3"><a href="{{ route('communities.index', $community->slug) }}" class="text-decoration-none text-center text-dark">{{ $community->name }}</a></li>
        @endforeach
    </ul>
    </div>
  </div>