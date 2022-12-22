
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
  console.log('yooow')
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