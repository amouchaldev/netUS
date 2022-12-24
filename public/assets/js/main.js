
// inial tinymce library for posts
function initShareForm() {
    tinymce.init({
        selector: '#mytextarea',
        height: 250,
        menubar: false,
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace visualblocks wordcount',
        
        toolbar: 'undo redo | fontsizeselect | blocks fontsize bold italic underline strikethrough | link image media mergetags | fontfamily addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
      });
}
// inial tinymce library for comments
function initCommentForm() {
  tinymce.init({
      selector: '#comment-form',
      height: 250,
      menubar: false,
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace visualblocks wordcount',
      toolbar: 'undo redo | fontsizeselect | blocks fontsize bold italic underline strikethrough | link image media mergetags | fontfamily addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    });
}
// function to follow/unfollow community 
function followCommunity(e, allowPlusIcon = true) {
  e.preventDefault()
  const community_id = e.target.getAttribute('data-community');
  let data = JSON.stringify({
  community_id: community_id
  })
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    console.log(this.responseText)
    response = JSON.parse(this.responseText)
    if (response.status == 'NOT AUTHENTICATED') {
          window.location.href = '/login'
    }
    else {
      if (response.status == 'followed') {
        e.target.innerHTML = 'unfollow'
        Swal.fire({
        position: 'center',
        icon: "success",
        title: 'Followed Successfully',
        showConfirmButton: false,
        timer: 1500
      })
    }
    else {
      e.target.innerHTML = allowPlusIcon ? '<i class="fa-solid fa-plus me-1 fa-sm"></i>' + 'follow' : 'follow'
      Swal.fire({
        position: 'center',
        icon: "success",
        title: 'Unfollowed Successfully',
        showConfirmButton: false,
        timer: 1500
      })
    }
    }
    }
  xhttp.open("POST", "/follow");
  xhttp.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  xhttp.setRequestHeader('Content-Type','application/json');
  xhttp.send(data);
}


 // delete post function 
 function _deletePost(post_id) {
  // console.log('yooow')
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
      const response = JSON.parse(this.responseText)
      console.log(response)
      // if post deleted successfully redirect to home page
      if (response.status) {
          window.location.href = '/'
      }
  } 
  xhttp.open('DELETE', '/post/' + post_id + '/delete')
  xhttp.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  xhttp.setRequestHeader('Content-Type','application/json');
  xhttp.send()
}

const post = document.querySelector('#post-show .post');
const posts = document.querySelectorAll('#posts .post');
const comments = document.querySelectorAll('#comments .comment');

window.onload = () => {
  // check if elements exists in current page and then toggle d-none class
  post && post.classList.toggle('d-none')
  comments && comments.forEach(comment => comment.classList.toggle('d-none'))
  posts && posts.forEach(post => post.classList.toggle('d-none'))
  
  document.querySelectorAll('.timeline-wrapper').forEach(item => item.remove())
  AOS.init();

}



function _updateComment(id, newComment) {
  const xhttp = new XMLHttpRequest();
  const _newComment = JSON.stringify({
      newComment: newComment
  })
  xhttp.onload = function() {
      const response = JSON.parse(this.responseText)
      console.log(response)
      if (response.status) {
          
      }
  } 
  xhttp.open('PATCH', '/comments/' + id + '/update')
  xhttp.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  xhttp.setRequestHeader('Content-Type', 'application/json');
  xhttp.send(_newComment)
 }


 function _like(route, id, likes_count) {
  // console.log(post_id, likes_count)

  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
      const response = JSON.parse(this.responseText)
      console.log(response)
      if (response.status) {
        likes_count.innerHTML = response.likes_count
      }
      else if (response.message == 'NOT AUTHENTICATED') {
        window.location.href = '/login'
      }
  } 
  // xhttp.open('POST', '/post/' + post_id + '/like')
  xhttp.open('POST', `/${route}/${id}/like`)
  xhttp.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  xhttp.setRequestHeader('Content-Type', 'application/json');
  xhttp.send()
}

function _dislike(route, id, likes_count) {
  // console.log(post_id, likes_count)
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
      const response = JSON.parse(this.responseText)
      console.log(response)
      if (response.status) {
        likes_count.innerHTML = response.likes_count
      }
      else if (response.message == 'NOT AUTHENTICATED') {
        window.location.href = '/login'
      }
  } 
  // xhttp.open('POST', '/post/' + id + '/dislike')
  xhttp.open('POST', `/${route}/${id}/dislike`)
  xhttp.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  xhttp.setRequestHeader('Content-Type', 'application/json');
  xhttp.send()
}




function likeDislikeCommentAction() {

  // LIKE / DESLIKE COMMENTS
  // # LIKE COMMENT:
  let likeComment = document.querySelectorAll('.like-comment') 

  likeComment.forEach(arrow => arrow.addEventListener('click', e => {
  _like('comments', e.target.parentElement.parentElement.previousElementSibling.value, e.target.nextElementSibling)
  }))

  // # DESLIKE COMMENT:
  let dislikeComment = document.querySelectorAll('.dislike-comment') 

  dislikeComment.forEach(arrow => arrow.addEventListener('click', e => {
  _dislike('comments', e.target.parentElement.parentElement.previousElementSibling.value, e.target.previousElementSibling)
  }))
}




function likeDislikePostsAction() {
  // LIKE / DESLIKE POST
     // # LIKE POST:
     const likePost = document.querySelector('.like-post') 
     likePost.addEventListener('click', e => {
         _like('post', e.target.parentElement.parentElement.previousElementSibling.value, e.target.nextElementSibling)
     })
     
     // # DESLIKE POST:
     const dislikePost = document.querySelector('.dislike-post') 
     dislikePost.addEventListener('click', e => {
         _dislike('post', e.target.parentElement.parentElement.previousElementSibling.value, e.target.previousElementSibling)
     })
         }


// show search box
const searchIcon = document.getElementById('search-icon')
const searchBox = document.querySelector('#search-box input')
searchIcon.addEventListener('click', () => {
  searchBox.classList.toggle('show')
  searchBox.focus()
})

searchBox.addEventListener('keyup', e => {
  if (e.key == 'Enter') {
      window.location.href = `/posts/${e.target.value}/search`
  }
})



function _socket() {
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
        document.querySelector(`#${response.type} input[value='${response.contentId}']`).nextElementSibling
            .querySelector('.likes_count').innerHTML = response.likes_count
    });
    // listen to post commented event
    channel.bind('postCommented', function(data) {
        // alert(JSON.stringify(data));
        const response = JSON.parse(JSON.stringify(data))
        console.log('....', response.comment)
        const {
            comment_id,
            body,
            post_id,
            user_id,
            created_at
        } = response.comment

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
            document.getElementById('comments').innerHTML = newComment + comments


            likeDislikeCommentAction()


        }
    });
}