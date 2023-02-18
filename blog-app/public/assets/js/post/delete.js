async function deletePost (postId) {
    try {
        let res = await axios({
            method: 'GET',
            url: `${baseUrl}/post/delete/${postId}`
        })
        res = res.data
        if (res.success) {
            loadPosts()
        } else {
            console.log(res.message)
        }
    }
    catch(err) {
        console.log('err: ', err)
    }
}
