window.addEventListener('load', () => {
    const URL = document.querySelector('.app.sidebar-mini').getAttribute('data-url')
    let btnModalNotification = document.querySelectorAll('.btn-modal-notification'),
        modalTitle = document.querySelector('#modalNotification .modal-title'),
        content = document.querySelector('[name=content]'),
        status = document.querySelector('[name=status]'),
        btnSave = document.querySelector('#modalNotification .btn-success'),
        sellerID

    btnModalNotification.forEach((btn) => {
        btn.addEventListener('click', () => {
            sellerID = btn.getAttribute('data-seller_id')
            getInfoNotification(sellerID)
        })
    })

    btnSave.addEventListener('click', () => {
        btnSave.classList.add('btn-loading')
        saveNotification(sellerID, content.value, status)
    })

    async function getInfoNotification(sellerID) {
        axios.get(`${URL}/admin/notifications/notification/${sellerID}`).then((response) => {
            modalTitle.innerHTML = response.data.full_name
            content.value = response.data.content
            response.data.status == 'active' ? status.checked = true : status.checked = false
        }).catch((error) => {
            console.error(error)
        })
    }
    
    async function saveNotification(sellerID, content, status) {
        axios.post(`${URL}/admin/notifications/notification`, {
            seller_id: sellerID,
            content,
            status: status.checked ? 'active' : 'inactive'
        }).then((response) => {
            if (response.data.status == 'success') {
                btnSave.classList.remove('btn-loading')
                btnSave.innerHTML = "<i class='fa fa-check'></i> Salvo"
                setTimeout(() => {
                    btnSave.innerHTML = 'Salvar'
                }, 2000)
            }
        }).catch((error) => {
            console.error(error)
        })
    }
})