function editPost (postId, callback) {
    loadEditForm (postId, callback)
}
function loadEditForm (postId, callback) {
    axios({
        method: 'GET',
        url: `${baseUrl}/post/${postId}`
    })
        .then(res => res.data)
        .then(res => {
            if (res.success) {
                showEditForm(res.data.post)
                handleEditFormSubmitButton(callback)
                handleCloseEditFormBtn()
            }
            else {
                console.log(res.message)
            }
        })
        .catch(err => console.log('err: ', err))
}

function showEditForm(post) {
    showPopupBg()

    const formCard = document.getElementById('edit_form_card')
    if (!formCard) {
        const container = document.getElementById('container')
        container.insertAdjacentHTML('beforeend', `
            <div class="card edit-form-card" id="edit_form_card">
                <div class="card-header d-flex justify-content-between">
                    Edit Post
                    <button class="btn btn-dark" id="close_edit_form_btn">x</button>
                </div>
                <div class="card-body">
                    <div>
                        <input type="hidden" name="post_id" id="post_id" value="${post.id}">
                        <div class="form-group">
                            <labe>Title</labe>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter post title" value="${post.title}">
                            <span class="text-danger"><strong id="title_validation_error"></strong></span>
                        </div>
                        <div class="form-group mt-3">
                            <labe>Description</labe>
                            <textarea name="content" id="content" class="form-control" rows="3" placeholder="Enter post content">${post.content}</textarea>
                            <span class="text-danger"><strong id="content_validation_error"></strong></span>
                        </div>
                        <button class="btn btn-primary mt-3" id="edit_form_submit_btn">Submit</button>
                    </div>
                </div>
            </div>
        `)
    }
}
function handleEditFormSubmitButton(callback) {
    const editFormSubmitBtn = document.getElementById('edit_form_submit_btn')
    editFormSubmitBtn.addEventListener('click', () => {
        const id = document.getElementById('post_id').value
        const title = document.getElementById('title').value
        const content = document.getElementById('content').value
        const titleValidationError = document.getElementById('title_validation_error')
        const contentValidationError = document.getElementById('content_validation_error')
        titleValidationError.innerHTML = ''
        contentValidationError.innerHTML = ''

        axios({
            method: 'POST',
            url: `${baseUrl}/post/update`,
            data: {
                _token: csrfToken,
                id,
                title,
                content
            }
        })
            .then(res => res.data)
            .then(res => {
                if (res.success) {
                    const formCard = document.getElementById('edit_form_card')
                    if (formCard) formCard.remove()
                    hidePopupBg()
                    callback(id)
                }
            })
            .catch(err => {
                console.log(err)
                if (err.response.data.errors) {
                    showValidationError(err.response.data.errors)
                }
            })
    })
}

function handleCloseEditFormBtn ()
{
    const button = document.getElementById('close_edit_form_btn')
    button.addEventListener('click', () => {
        hidePopupBg()
        hideCreteFormPopup()
    })
}

function hideCreteFormPopup () {
    const formCard = document.getElementById('edit_form_card')
    if (formCard) formCard.remove()
}
