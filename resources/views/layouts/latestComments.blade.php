<ul class="list-group">
    <li class="list-group-item list-group-item-action"><h5 class="mb-0">lastest comments</h5></li>
    @foreach($latestComments as $comment)
    <li class="list-group-item list-group-item-action d-flex"><a href="#" class="text-dark text-decoration-none">
        <a 
        href="{{ route('users.show', $comment->user->username) }}" 
        class="text-decoration-none me-1">{{ $comment->user->name }}
        </a>
        <span>
            {!! $comment->body !!}
        </span>
    </li>
    @endforeach
</ul>