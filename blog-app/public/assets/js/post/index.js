function loadPosts () {
    console.log("loadPosts")
    axios({
        method: 'GET',
        url: `${baseUrl}/post/list`
    })
        .then(res => res.data)
        .then(res => {
            if (res.success) {
                renderPosts(res.data.posts)
                handleDetailsButtons()
            }
            else {
                let postsDom = document.getElementById('posts')
                postsDom.innerHTML = res.message
            }
        })
        .catch(err => console.log('err: ', err))
}

function renderPosts(posts) {
    let postsDom = document.getElementById('posts')
    postsDom.innerHTML = ''
    if (posts.length===0) {
        postsDom.innerHTML = 'No Post Available'
    }
    else {
        for (let i=0; i<posts.length; i++) {
            appendPost(posts[i], i)
        }
    }
}

function appendPost (post, index) {
    let postsDom = document.getElementById('posts')
    postsDom.insertAdjacentHTML('beforeend', `
        <div class="post-item d-flex justify-content-between mt-3">
            <div class="post-title">
                <span class="details-btn cursor-pointer" data-id="${post.id}">${post.title}</a>
            </div>
            <div class="post-actions">
                <span class="btn btn-info edit-btn" data-id="${post.id}">Edit</span>
                <span class="btn btn-danger delete-btn" data-id="${post.id}">Delete</span>
            </div>
        </div>
    `)
}


