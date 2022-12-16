<form action="{{ route($route, in_array($route, ['posts.update', 'comments.store']) ? $post->id : null) }}" method="POST" enctype="multipart/form-data">
    @method($method)
    @csrf
    @if($type == 'post')
        <div class="mb-3">
            <label for="" class="form-label">community</label>
            <select name="community" id="" class="form-select">
                @foreach(App\Models\Community::all() as $community)
                    <option class="text-capitalize" value="{{ $community->id }}" 
                        @if($route == 'posts.edit')
                        {{ $post->community->id == $community->id ? 'selected' : '' }}
                        @endif
                        >{{ $community->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">title</label>
            <input type="text" class="form-control" name="title" value="{{ old('title', $post->title ?? null) }}">
        </div>
    @endif

    <div class="mb-3">
        @if(in_array(Route::currentRouteName(), ['posts.share', 'posts.edit']))
        <label for="" class="form-label">Content</label>
        @endif
        <textarea class="tinymce-editor" id="mytextarea" name="body">
            {{ old('name', $route == 'posts.update' ? $post->body : '') }}
        </textarea>
    </div>

    {{-- @if($type == 'comment')
    <input type="hidden" value="{{ $post->id }}" name="post_id">
    @endif --}}
    
    <div class="mb-3">
        <button type="submit" class="btn btn-primary btn-block">
            {{-- {{ 
                Route::currentRouteName() == 'posts.share' ? 'Publish' : Route::currentRouteName() == 'posts.show' ? 'comment' : 'update' 
            }} --}}
            @if(Route::currentRouteName() == 'posts.share')
                Publish
            @elseif(Route::currentRouteName() == 'posts.show')
                Comment
            @else 
                Update
            @endif
        </button>
    </div>

</form>