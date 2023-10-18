window.addEventListener('load', () => {
    const URL = document.querySelector('body.sidebar-mini').getAttribute('data-url')
    let btnDeleteNegotiations = document.querySelector('.btn-delete-negotiations')
    let checkboxesCheckedP = document.querySelector('.checkboxes-checked')
    let checkboxes = document.querySelectorAll('input[name=client_id]')

    checkboxes.forEach((item) => {
        item.addEventListener('change', () => {
            checkboxesVerify(checkboxes)
        })
    })

    btnDeleteNegotiations.addEventListener('click', async () => {
        btnDeleteNegotiations.classList.add('btn-loading')
        let checkboxesChecked = []
        checkboxes.forEach((item) => {
            if (item.checked) {
                checkboxesChecked.push(item.getAttribute('id'))
            }
        })

        for (let i = 0; i < checkboxesChecked.length; i++) {
            checkboxesCheckedP.innerHTML = `${i + 1}/${checkboxesChecked.length}`
            await axios.post(`${URL}/admin/clients/delete/${checkboxesChecked[i]}`, {
                action: 'delete',
                client_id: checkboxesChecked[i]
            }, {
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then((response) => {
                if (response.data.redirect && i === checkboxesChecked.length - 1) {
                    window.location.href = response.data.redirect
                }
            }).catch((error) => {
                console.error(error)
            })
        }
    })

    function checkboxesVerify(checkboxes) {
        let checkboxesChecked = []
        checkboxes.forEach((item) => {
            if (item.checked) {
                checkboxesChecked.push(item)
            }
        })

        if (checkboxesChecked.length > 0) {
            btnDeleteNegotiations.classList.contains('d-none') ? btnDeleteNegotiations.classList.remove('d-none') : null
        } else {
            !btnDeleteNegotiations.classList.contains('d-none') ? btnDeleteNegotiations.classList.add('d-none') : null
        }
    }
})