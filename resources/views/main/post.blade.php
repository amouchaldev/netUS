@extends('master')
@section('content')
<div class="row">

    <div class="col-12">

        <h1 class="col-lg-8 h3 my-4"><a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none">{{ $post->title }}</a></h1>
        <div class="row">
    
            <div class="col-12 col-lg-8 mb-5 mb-lg-0">
                    <div class="row">
                    <div class="col-12" id="post-show">
                        {{-- placeholder loading --}}
                        <x-post-placeholder></x-post-placeholder>
                        {{-- post --}}
                        <x-post-card :post="$post"></x-post-card>
                    @auth
                    {{-- comment form --}}
                    <x-create-form
                        route='comments.store'
                        :post="$post"
                    ></x-create-form>
                    @endauth
                    {{-- comments --}}
                    <div id="comments">
                        <h5 class="my-4">Comments</h5>
                        
                        
                        {{-- placeholder loading --}}
                        @if(count($comments) > 0)  
                        <x-post-placeholder height="200px"></x-post-placeholder>
                        <x-post-placeholder height="200px"></x-post-placeholder>
                        <x-post-placeholder height="200px"></x-post-placeholder>
                        <x-post-placeholder height="200px"></x-post-placeholder>
                        @endif
                        @forelse($comments as $comment)
                            <x-comment-card
                            :comment="$comment"
                            {{-- :community="$post->community->" --}}
                            ></x-comment-card>
                        @empty
                            <p class="alert alert-info">No Comment Yet</p>
                        @endforelse
                    </div>

                    {{-- learn also --}}
                    <h5 class="my-4">Also learn</h5>
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-action"><a href="#" class="text-dark text-decoration-none">Cras justo odio</a></li>
                        <li class="list-group-item list-group-item-action"><a href="#" class="text-dark text-decoration-none">Cras justo odio</a></li>
                        <li class="list-group-item list-group-item-action"><a href="#" class="text-dark text-decoration-none">Cras justo odio</a></li>
                        <li class="list-group-item list-group-item-action"><a href="#" class="text-dark text-decoration-none">Cras justo odio</a></li>
                    </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-lg-4">
                <x-communities :communities="$recommendedCommunities"></x-communities>
            </div>
            
        </div>
    </div>

</div>


@endsection

@section('javascripts')
{{-- sweet alert library --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- tinymce --}}
<script src="{{ asset('assets/tinymce/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script type="text/javascript">
    // # DELETE POST
    // get delete document element
    const deletePost = document.querySelector('#delete-post')
    deletePost.addEventListener('click', e => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3459E6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                _deletePost(e.target.getAttribute('data-id'))
            }
        })
    });
    // # DELETE COMMENT 
   // get edit document elements
   const editComment = document.querySelectorAll('.edit-comment')
   editComment.forEach(el => {
       el.addEventListener('click', e => {

           let commentBody = e.target.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.nextElementSibling
           
           commentBody.innerHTML = `<textarea class="tinymce-editor" id="comment-form" name="body">${commentBody.innerHTML}</textarea>`
           initCommentForm()
            //    tinymce.get("comment-form").setContent("<p>Hello world!</p>");                          
           setTimeout(() => {
               document.addEventListener('click', function(event) {
                   const outsideClick = !commentBody.contains(event.target);
                   if (outsideClick) {
                       if (commentBody.contains(commentBody.querySelector('textarea'))) {
                        console.log(tinymce.get("comment-form").getContent())
                        
                        commentBody.innerHTML = tinymce.get("comment-form").getContent()
                    //   console.log('===>', commentBody.querySelector('textarea').innerHTML)
                       _updateComment(e.target.getAttribute('data-id'), tinymce.get("comment-form").getContent())

                    }
            
                }
            }, 
            {once: true}
            );
                   }, 100);
        })
   })


   initShareForm()

    let follow = document.querySelectorAll('.follow')
    follow.forEach(community => {
        community.addEventListener('click', followCommunity)
    })


    // LIKE / DESLIKE POST
    // # LIKE:
    const likeArrow = document.querySelector('.like-post') 
    likeArrow.addEventListener('click', e => {
        _likePost(e.target.parentElement.parentElement.previousElementSibling.value, e.target.nextElementSibling)
    })
    
        function _likePost(post_id, likes_count) {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                const response = JSON.parse(this.responseText)
                console.log(response)
                if (response.message == 'OK') {
                    likes_count.innerHTML = parseInt(likes_count.innerHTML) + 1
                }
                else if (response.message == 'LIKED') {
                    likes_count.innerHTML = parseInt(likes_count.innerHTML) == -1 ? + 2 : 1
                }
                else if (response.message == 'DELETED') {
                    likes_count.innerHTML = parseInt(likes_count.innerHTML) > 0 ? parseInt(likes_count.innerHTML) - 1 : 0
                }
                else if (response.message == 'NOT AUTHENTICATED') {
                    Swal.fire({
                        title: 'You Are Not Authenticated',
                    })
                    // window.location.href = '/login'
                }
            } 
            xhttp.open('POST', '/post/' + post_id + '/like')
            xhttp.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
            xhttp.setRequestHeader('Content-Type', 'application/json');
            xhttp.send()
    }
    // # DESLIKE:
    const deslikeArrow = document.querySelector('.deslike-post') 
    deslikeArrow.addEventListener('click', e => {
        _deslikePost(e.target.parentElement.parentElement.previousElementSibling.value, e.target.previousElementSibling)
    })
    function _deslikePost(post_id, likes_count) {
            console.log(post_id, likes_count)
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                const response = JSON.parse(this.responseText)
                console.log(response)
                if (response.message == 'OK') {
                    likes_count.innerHTML = parseInt(likes_count.innerHTML) == 1 ? - 2 : - 1
                }
                else if (response.message == 'DISLIKED') {
                    likes_count.innerHTML = parseInt(likes_count.innerHTML) == 1 ?  -2 : -1
                }
                else if (response.message == 'DELETED') {
                    likes_count.innerHTML = parseInt(likes_count.innerHTML) + 1
                }
                else if (response.message == 'NOT AUTHENTICATED') {
                    Swal.fire({
                        title: 'You Are Not Authenticated',
                    })
                    // window.location.href = '/login'
                }
            } 
            xhttp.open('POST', '/post/' + post_id + '/dislike')
            xhttp.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
            xhttp.setRequestHeader('Content-Type', 'application/json');
            xhttp.send()
    }


</script>


@endsection