<nav class="navbar navbar-expand navbar-dark bg-primary text-white p-1">
    <div class="container">
      <div class="d-flex align-items-center">
          <a 
              class="text-light" 
              data-bs-toggle="offcanvas" 
              href="#left-bar" 
              role="button" 
              aria-controls="offcanvasExample">
              <i class="fa-solid fa-bars fa-xl me-4"></i>
          </a>
          <a class="navbar-brand me-0" href="/"><img src="{{ asset('assets/img/logo-light.png') }}" alt="logo" class="logo"></a>
      </div>
      <button 
      class="navbar-toggler d-lg-none" 
      type="button" 
      data-bs-toggle="collapse" 
      data-bs-target="#collapsibleNavId" 
      aria-controls="collapsibleNavId"
      aria-expanded="false" 
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="collapsibleNavId">
          <ul class="navbar-nav me-auto mt-lg-0">
              <li class="nav-item">
                  <a class="nav-link text-uppercase" href="{{ route('posts.share') }}" aria-current="page"><i class="fa fa-plus me-1 "></i>Share <span class="visually-hidden">(current)</span></a>
              </li>

          </ul>
          @auth
          <ul class="navbar-nav ms-auto mt-lg-0">
              <li class="nav-item">
                  <i class="fa-solid fa-magnifying-glass fa-lg mx-1"></i>
              </li>
              {{-- <li class="nav-item">
                  <i class="fa-solid fa-envelope fa-lg mx-1"></i>
              </li> --}}
              <li class="nav-item">
                  <i class="fa-solid fa-bell fa-lg mx-1"></i>
              </li>
              <li class="dropdown">
                  <span 
                  class="dropdown-toggle ms-2" 
                  type="button" 
                  id="triggerId" 
                  data-bs-toggle="dropdown" 
                  aria-haspopup="true"
                  aria-expanded="false">        
                  <i class="fa-solid fa-user"></i>
                  </span>
                  <div class="dropdown-menu" aria-labelledby="triggerId">
                      <a class="dropdown-item" href="{{ route('users.show', Auth::user()->username) }}">{{ Auth::user()->fName }}</a>
                      <a class="dropdown-item disabled" href="#">Disabled action</a>
                      <h6 class="dropdown-header">Section header</h6>
                      <a class="dropdown-item" href="#">Action</a>
                      <div class="dropdown-divider"></div>
                      <form action="{{ route('logout') }}" method="POST" id="logout" class="dropdown-item">
                            @csrf
                            <input type="submit" value="log out" class="border-0 bg-transparent">
                      </form>
                  </div>
              </li>
          </ul>
          @endauth

          @guest
            <div>
                <a href="{{ route('login') }}" class="btn btn-outline-light text-light btn-sm me-2 fw-normal"><i class="fa-solid fa-right-to-bracket"></i> log in</a>
                <a href="{{ route('register') }}" class="btn btn-outline-light text-light btn-sm fw-normal"><i class="fa-solid fa-user-plus"></i> sign up</a>
            </div>
          @endguest
      </div>
</div>
</nav>


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
            @foreach(App\Models\Community::all() as $community)
                <li class="mb-1 py-3"><a href="{{ route('communities.index', $community->slug) }}" class="text-decoration-none text-center text-dark">{{ $community->name }}</a></li>
            @endforeach
        </ul>
        </div>
      </div>