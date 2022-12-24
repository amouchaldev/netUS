<div class="p-3 bg-white rounded mb-3 comment d-none" data-aos="fade-down">
    <input type="hidden" value="{{ $comment->id }}">
    <div class="d-flex align-items-center mb-3">
        <div class="me-4 text-center">
            <i class="fa-solid fa-chevron-up text-primary like-comment cursor-pointer"></i>
            <div class="likes_count">{{ $comment->likes_count - $comment->dislikes_count }}</div>
            <i class="fa-solid fa-chevron-down text-primary dislike-comment cursor-pointer"></i>
        </div>

        <div class="d-flex flex-column">
            <a href="{{ route('users.show', $comment->user->username) }}"
                class="d-flex align-items-center mb-2 text-decoration-none text-dark">
                <div class="card-avatar overflow-hidden">
                    <img src="{{ asset('storage/' . $comment->user->avatar) }}" alt="" class="w-100 h-100">
                </div>
                <h6 class="mb-0 ms-2">
                    {{ $comment->user->name }}
                </h6>
            </a>

            <div class="d-flex flex-wrap align-items-center">
                <small class="me-2"><i class="fa-regular fa-clock fa-xs"></i>
                    {{ $comment->created_at->diffForHumans() }}</small>
                {{-- <small class="me-2"><i class="fa-solid fa-reply"></i> reply</small> --}}
                {{-- more --}}
                @if (Gate::check('update', $comment) || Gate::check('delete', $comment))
                    <div class="dropdown d-inline">
                        <small class="me-2 dropdown-toggle" type="button" id="moreDropDown" data-bs-toggle="dropdown"
                            aria-expanded="false"><i class="fa-solid fa-caret-down fa-sm"></i> more</small>
                        <ul class="dropdown-menu" aria-labelledby="moreDropDown">
                            @can('update', $comment)
                                <li><span class="dropdown-item edit-comment" data-id="{{ $comment->id }}">edit</span></li>
                            @endcan
                            <li>
                                <form action="{{ route('comments.delete', $comment->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="dropdown-item" value="delete">
                                </form>
                                {{-- <li><a class="dropdown-item" href="#">Something else here</a></li> --}}
                        </ul>
                    </div>
                @endif
            </div>
        </div>

    </div>
    <div class="comment-body" id="comment-body-{{ $comment->id }}">
        {!! $comment->body !!}
    </div>
</div>
