@extends('master')

@section('content')
    <div class="row">
        <div class="col-12">
            <h3>Share</h3>
            <p>share something intersting</p>
            <div class="row">
                <div class="col-8">
                    <div class="p-4 bg-white rounded shadow">
                        <x-create-form 
                        type="post"
                        
                        route="posts.store"
                        ></x-create-form>
                    </div>
                </div>
                <div class="col-4">
                    <x-communities :communities="$recommendedCommunities"></x-communities>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascripts')
{{-- sweet alert library --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('assets/tinymce/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>

<script type="text/javascript">
    initShareForm()
    let follow = document.querySelectorAll('.follow')
  follow.forEach(community => {
    community.addEventListener('click', followCommunity)
  })
</script>

@endsection