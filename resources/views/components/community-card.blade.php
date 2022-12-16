<div class="list-group-item list-group-item-action flex-column align-items-start @if(Route::currentRouteName() == 'communities') bg-white rounded p-3 @endif">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1"><a href="{{ route("communities.index", $community->slug) }}" class="text-decoration-none">{{ $community->name }}</a></h5>
    </div>
    <p class="mb-3">{{ $community->description }}</p>
    <div class="d-flex justify-content-between align-items-center">
        <small class="text-primary follow cursor-pointer" data-community="{{ $community->id }}"><i class="fa-solid fa-plus me-1 fa-sm"></i>follow</small>
        <small>{{ $community->users_count }} follow</small>
    </div>
</div>