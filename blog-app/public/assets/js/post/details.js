function handleDetailsButtons() {
    let detailsBtns = document.querySelectorAll('.details-btn')
    for (let i=0; i<detailsBtns.length; i++) {
        detailsBtns[i].addEventListener('click', function () {
            let postId = detailsBtns[i].getAttribute('data-id')
            loadPost(postId)
        })
    }
}
async function loadPost (postId) {
    try {
        let res  = await axios({
            method: 'GET',
            url: `${baseUrl}/post/${postId}`
        })
        res = res.data
        if (res.success) {
            showPostDetails(res.data.post)
            handleClosePostDetailsBtn()
            handleEditBtn()
            handleDeleteBtn()
        } else {
            console.log(res.message)
        }
    }
    catch(err) {
        console.log('err: ', err)
    }
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
                <span class="btn btn-info cursor-pointer" id="edit_btn" data-id="${post.id}">Edit</span>
                <span class="btn btn-danger cursor-pointer" id="delete_btn" data-id="${post.id}">Delete</span>
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
function handleEditBtn ()
{
    const editBtn = document.getElementById('edit_btn')
    editBtn.addEventListener('click', () => {
        let postId = editBtn.getAttribute('data-id')
        hidePopupBg()
        hidePostDetailsPopup()
        editPost(postId, loadPost)
    })
}
function handleDeleteBtn ()
{
    const deleteBtn = document.getElementById('delete_btn')
    deleteBtn.addEventListener('click', () => {
        let postId = deleteBtn.getAttribute('data-id')
        hidePopupBg()
        hidePostDetailsPopup()
        deletePost(postId)
    })
}

function hidePostDetailsPopup () {
    const detailsCard = document.getElementById('post_details_card')
    if (detailsCard) detailsCard.remove()
}
