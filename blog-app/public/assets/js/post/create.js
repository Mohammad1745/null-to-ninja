function handleCreateButton() {
    const createBtn = document.getElementById('create_btn')
    createBtn.addEventListener('click', () => {
        showCreateForm()
        handleCreateFormSubmitButton()
        handleCloseCreateFormBtn()
    })
}

function showCreateForm() {
    showPopupBg()

    const formCard = document.getElementById('create_form_card')
    if (!formCard) {
        const container = document.getElementById('container')
        container.insertAdjacentHTML('beforeend', `
                    <div class="card create-form-card" id="create_form_card">
                        <div class="card-header d-flex justify-content-between">
                            Create Post
                            <button class="btn btn-dark" id="close_create_form_btn">x</button>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="form-group">
                                    <labe>Title</labe>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter post title" value="">
                                    <span class="text-danger"><strong id="title_validation_error"></strong></span>
                                </div>
                                <div class="form-group mt-3">
                                    <labe>Description</labe>
                                    <textarea name="content" id="content" class="form-control" rows="3" placeholder="Enter post content"></textarea>
                                    <span class="text-danger"><strong id="content_validation_error"></strong></span>
                                </div>
                                <button class="btn btn-primary mt-3" id="create_form_submit_btn">Submit</button>
                            </div>
                        </div>
                    </div>
                `)
    }
}
function handleCreateFormSubmitButton() {
    const createFormSubmitBtn = document.getElementById('create_form_submit_btn')
    createFormSubmitBtn.addEventListener('click', async () => {
        const title = document.getElementById('title').value
        const content = document.getElementById('content').value
        const titleValidationError = document.getElementById('title_validation_error')
        const contentValidationError = document.getElementById('content_validation_error')
        titleValidationError.innerHTML = ''
        contentValidationError.innerHTML = ''

        try{
            let res = await axios({
                method: 'POST',
                url: `${baseUrl}/post`,
                data: {
                    _token: csrfToken,
                    title,
                    content
                }
            })

            res = res.data
            if (res.success) {
                const formCard = document.getElementById('create_form_card')
                if (formCard) formCard.remove()
                hidePopupBg()
                loadPosts()
            }

        }
        catch(err) {
            console.log(err)
            if (err.response.data.errors) {
                showValidationError(err.response.data.errors)
            }
        }
    })
}

function handleCloseCreateFormBtn ()
{
    const button = document.getElementById('close_create_form_btn')
    button.addEventListener('click', () => {
        hidePopupBg()
        hideCreteFormPopup()
    })
}

function hideCreteFormPopup () {
    const formCard = document.getElementById('create_form_card')
    if (formCard) formCard.remove()
}
