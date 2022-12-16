<ul class="nav nav-tabs col-lg-8 my-4">
  <li class="nav-item">
    <a class="nav-link {{ $tab == 'latest' ? 'active' : '' }}" aria-current="page" href="/">Latest</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ $tab == 'popular' ? 'active' : '' }}" href="{{ route('posts.popular') }}">popular</a>
  </li>
</ul>