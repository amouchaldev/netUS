<div class="px-3 py-4 bg-white rounded mb-3 d-none post" data-aos="fade-down">
    <input type="hidden" value="{{ $post->id }}">

    <div class="d-flex align-items-center">
        <div class="me-4 text-center likes">
            <i class="fa-solid fa-chevron-up text-primary like-post cursor-pointer"></i>
            <div class="likes_count">{{ $post->likes_count }}</div>  
            <i class="fa-solid fa-chevron-down text-primary deslike-post cursor-pointer"'></i>
    </div>

        <div class="d-flex flex-column">
            <a href="{{ route('users.show', $post->user->username) }}" class="d-flex align-items-center mb-2 text-decoration-none text-dark">
                <div class="card-avatar overflow-hidden">
                    <img 
                    src="{{ asset('storage/' . $post->user->avatar) }}"
                     alt="" class="w-100 h-100">
                </div>
                <h6 class="mb-0 ms-2">
                    {{ $post->user->fName . ' ' .  $post->user->lName}}
                </h6>
            </a>

            <div>
                <a class="text-reset text-decoration-none me-2" href="{{ route('communities.index', $post->community->slug) }}"><i class="fa-solid fa-bars fa-xs"></i> <small>{{ $post->community->name }}</small></a>
                <small class="me-2"><i class="fa-regular fa-clock fa-sm"></i> {{ $post->created_at->diffForHumans() }}</small>
                <small class="me-2"><i class="fa-regular fa-eye fa-sm"></i> {{ $post->number_visites }}</small>
                <small class="me-2"><i class="fa-regular fa-comment fa-sm"></i> {{ $post->comments_count }} comments</small>
                 {{-- more --}}
                 {{-- @auth --}}
                 @if(Route::currentRouteName() == 'posts.show')
                 <div class="dropdown d-inline">
                    <small class="me-2 dropdown-toggle" type="button" id="moreDropDown" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-caret-down fa-sm"></i> more</small>
                    <ul class="dropdown-menu" aria-labelledby="moreDropDown">
                         <li><a class="dropdown-item" href="{{ route('posts.edit', $post->slug) }}">edit</a></li>
                         <li><span 
                            id="delete-post"
                             class="dropdown-item" 
                             data-id="{{ $post->id }}"
                             >delete</span>
                        </li>
                    </ul>
                 </div>
                 @endif
                 {{-- @endauth --}}
            </div>

            {{-- title --}}
            @if(Route::currentRouteName() != 'posts.show')
            <h5 class="mt-3"><a href="{{ route('posts.show', $post->slug ?? null) }}" class="text-decoration-none text-primary">{{ $post->title }}</a></h5>
            @endif

        </div>

    </div>


@if(Route::currentRouteName() == 'posts.show')
<p>
    {{-- {!! Route::currentRouteName() == 'posts.show' ? $post->body : Str::limit($post->body, 230) !!} --}}
    {!! Route::currentRouteName() == 'posts.show' ? $post->body : '' !!}
    {{-- {!! $post->body !!} --}}
</p>
@endif
</div>
