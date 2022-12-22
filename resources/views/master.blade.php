<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <title>@yield('title')</title>
    @yield('stylesheets')
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;
        var pusher = new Pusher('cdc1115423930818ff5b', {
        cluster: 'eu'
        });

        var channel = pusher.subscribe('public-channel');
        // listen to like or dislike event
        channel.bind('action', function(data) {
        // alert(JSON.stringify(data));
            const response = JSON.parse(JSON.stringify(data))
            // console.log(response, document.querySelector(`#${response.type} input[value='${response.contentId}']`).nextElementSibling.querySelector('.likes_count').innerHTML)
            document.querySelector(`#${response.type} input[value='${response.contentId}']`).nextElementSibling.querySelector('.likes_count').innerHTML = response.likes_count
        });
        // listen to post commented event
        channel.bind('postCommented', function(data) {
        // alert(JSON.stringify(data));
            const response = JSON.parse(JSON.stringify(data))
            console.log('....', response.comment)
            const {comment_id, body, post_id, user_id, created_at} = response.comment
           
            console.log("post_id ===>", comment_id)
            console.log("input ===>", document.querySelector(`#posts input`).value)
            if (document.querySelector(`#posts input`).value == post_id) {
                // console.log(response.comment)
                const newComment = `
                <div class="p-3 bg-white rounded mb-3 comment">
                    <input type="hidden" value="${response.comment.id}">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-4 text-center">
                            <i class="fa-solid fa-chevron-up text-primary like-comment cursor-pointer"></i>
                            <div class="likes_count">0</div>  
                            <i class="fa-solid fa-chevron-down text-primary dislike-comment cursor-pointer"></i>
                    </div>

                    <div class="d-flex flex-column">
                        <a href="/user/${response.user.username}" class="d-flex align-items-center mb-2 text-decoration-none text-dark">
                            <div class="card-avatar overflow-hidden">
                                <img 
                                src="/storage/${response.user.avatar}"
                                alt="" class="w-100 h-100">
                            </div>
                            <h6 class="mb-0 ms-2">
                                ${response.user.name}
                            </h6>
                        </a>
                    <div>
                <small class="me-2"><i class="fa-regular fa-clock fa-xs"></i> 2 seconds ago</small>
            </div>
        </div>
    </div>
    <div class="comment-body" id="comment-body-${response.comment.id}">
        ${body}
    </div>
</div>`


    const comments = document.getElementById('comments').innerHTML 
    document.getElementById('comments').innerHTML =  newComment + comments
   
   
    likeDislikeCommentAction()


    }});
    </script>
</head>
<body>

    @include('layouts.navbar')

    @yield('profile')
    @yield('chat')

    <div class="container {{ Route::currentRouteName() != 'chat' ? 'py-4' : ''}}">
        @yield('content')
    </div>

    @include('layouts.footer')

    {{-- @vite(['resources/js/app.js']) --}}
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @yield('javascripts')
  
</body>
</html>