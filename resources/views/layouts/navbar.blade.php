<nav class="navbar navbar-expand navbar-dark bg-primary text-white p-1">
    <div class="container d-flex flex-column flex-sm-row">
      <div class="d-flex align-items-center">
          <a 
              class="text-light" 
              data-bs-toggle="offcanvas" 
              href="#left-bar" 
              role="button" 
              aria-controls="offcanvasExample">
              <i class="fa-solid fa-bars fa-xl me-4"></i>
          </a>
          <a class="navbar-brand me-0" href="/">
            <img src="{{ asset('assets/img/logo-light.png') }}" alt="logo" class="logo">
        </a>
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
                <a class="nav-link text-uppercase" 
                  href="{{ route('posts.share') }}" 
                  aria-current="page">
                  <i class="fa fa-plus me-1 "></i>Share 
                  <span class="visually-hidden">(current)</span>
                </a>
              </li>

          </ul>
          <ul class="navbar-nav ms-auto mt-lg-0">
            <li class="nav-item cursor-pointer" id="search-icon">
              <i class="fa-solid fa-magnifying-glass fa-lg mx-1"></i>
            </li>
            @auth
              <li class="nav-item">
                <a href="/chat" class="text-decoration-none text-light"><i class="fa-solid fa-envelope fa-lg mx-1"></i></a>
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
                      <a class="dropdown-item" href="{{ route('users.show', Auth::user()->username) }}">{{ Auth::user()->username }}</a>
                      @if(Auth::user()->role == 'admin')
                        <a class="dropdown-item" href="{{ route('users.pending.list') }}">pending members</a>
                      @endif
                      <div class="dropdown-divider"></div>
                      <form action="{{ route('logout') }}" method="POST" id="logout" class="dropdown-item">
                            @csrf
                            <input type="submit" value="log out" class="border-0 bg-transparent">
                      </form>
                  </div>
                </li>
                @endauth
          </ul>

          @guest
            <div>
                <a href="{{ route('login') }}" class="btn text-light btn-sm me-2 fw-normal"><i class="fa-solid fa-right-to-bracket"></i> log in</a>
                <a href="{{ route('register') }}" class="btn text-light btn-sm fw-normal"><i class="fa-solid fa-user-plus"></i> sign up</a>
            </div>
          @endguest
      </div>
</div>
</nav>
<div id="search-box" class="bg-white shadow">
    <div class="container">
            <input type="text" class="form-control rounded-0 shadow-none border-0" placeholder="Look for ..">
    </div>
</div>


   