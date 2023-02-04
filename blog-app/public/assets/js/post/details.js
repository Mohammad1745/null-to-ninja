function handleDetailsButtons() {
    let detailsBtns = document.querySelectorAll('.details-btn')
    for (let i=0; i<detailsBtns.length; i++) {
        detailsBtns[i].addEventListener('click', function () {
            let postId = detailsBtns[i].getAttribute('data-id')
            loadPost(postId)
        })
    }
}
function loadPost (postId) {
    axios({
        method: 'GET',
        url: `${baseUrl}/post/${postId}`
    })
        .then(res => res.data)
        .then(res => {
            if (res.success) {
                showPostDetails(res.data.post)
                handleClosePostDetailsBtn()
            }
            else {
                console.log(res.message)
            }
        })
        .catch(err => console.log('err: ', err))
}
function showPostDetails (post) {
    hidePostDetailsPopup()
    showPopupBg()
    const container = document.getElementById('container')

    container.insertAdjacentHTML('beforeend', `
                <div class="card post-details-card" id="post_details_card">
                    <div class="card-header d-flex justify-content-between">
                        Post Details
                        <button class="btn btn-dark" id="close_post_details_btn">x</button>
                    </div>
                    <div class="card-body">
                        <div class="card-header">${post.title}</div>
                        <div class="card-body">${post.content}</div>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-info" href="">Edit</a>
                        <a class="btn btn-danger" href=""
                           onclick="return confirm('Do you want to delete?')">Delete</a>
                    </div>
                </div>
            `)
}

function handleClosePostDetailsBtn ()
{
    const button = document.getElementById('close_post_details_btn')
    button.addEventListener('click', () => {
        hidePopupBg()
        hidePostDetailsPopup()
    })
}

function hidePostDetailsPopup () {
    const detailsCard = document.getElementById('post_details_card')
    if (detailsCard) detailsCard.remove()
}
