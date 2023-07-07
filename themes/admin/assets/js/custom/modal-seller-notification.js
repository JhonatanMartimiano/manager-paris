window.addEventListener('load', () => {
    let btnModalNotification = document.querySelector('.btn-global-modal-notification'),
        modalNotification = document.querySelector('#modalNotificationGlobal')
    
    if (modalNotification.getAttribute('data-notification-status') == 'active') {
        btnModalNotification.click()
    }
})