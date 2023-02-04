function showPopupBg() {
    hidePopupBg()
    const body = document.getElementById('body')
    body.insertAdjacentHTML('beforeend', `<div class="popup-bg" id="popup_bg"></div>`)
}

function hidePopupBg() {
    const popupBg = document.getElementById('popup_bg')
    if (popupBg) popupBg.remove()
}

function showValidationError(errors) {
    Object.keys(errors).forEach(key => {
        const dom =  document.getElementById(key+'_validation_error')
        dom.innerHTML = errors[key][0]
    })
}
