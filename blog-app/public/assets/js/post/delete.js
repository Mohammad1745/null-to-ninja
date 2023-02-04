function deletePost (postId) {
    axios({
        method: 'GET',
        url: `${baseUrl}/post/delete/${postId}`
    })
        .then(res => res.data)
        .then(res => {
            if (res.success) {
                loadPosts()
            }
            else {
                console.log(res.message)
            }
        })
        .catch(err => console.log('err: ', err))
}
