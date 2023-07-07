window.addEventListener("load", () => {
    const URL = document.querySelector(".app.sidebar-mini").getAttribute("data-url")
    let btnLate = document.querySelector(".btn-late"),
        btnCompleted = document.querySelector(".btn-completed"),
        btnWaiting = document.querySelector(".btn-waiting"),
        btnInNegotiation = document.querySelector(".btn-inNegotiation"),
        btnLoss = document.querySelector(".btn-loss"),
        btnFuture = document.querySelector(".btn-future"),
        lateResult = document.querySelector(".late-result"),
        completedResult = document.querySelector(".completed-result"),
        waitingResult = document.querySelector(".waiting-result"),
        inNegotiationResult = document.querySelector(".inNegotiation-result"),
        lossResult = document.querySelector(".loss-result"),
        futureResult = document.querySelector(".future-result")

    btnLate.addEventListener("click", () => {
        btnLate.classList.add("btn-loading")
        syncLate()
    })

    btnCompleted.addEventListener("click", () => {
        btnCompleted.classList.add("btn-loading")
        syncCompleted()
    })

    btnWaiting.addEventListener("click", () => {
        btnWaiting.classList.add("btn-loading")
        syncWaiting()
    })

    btnInNegotiation.addEventListener("click", () => {
        btnInNegotiation.classList.add("btn-loading")
        syncInNegotiation()
    })

    btnLoss.addEventListener("click", () => {
        btnLoss.classList.add("btn-loading")
        syncLoss()
    })

    btnFuture.addEventListener("click", () => {
        btnFuture.classList.add("btn-loading")
        syncFuture()
    })

    async function syncLate() {
        await axios.post(`${URL}/admin/dash/contact-type/ajax`, {
            contact_type: "late"
        }).then((response) => {
            lateResult.innerHTML = response.data.result
            btnLate.classList.remove("btn-loading")
        }).catch((error) => {
            console.error(error)
        })
    }

    async function syncCompleted() {
        await axios.post(`${URL}/admin/dash/contact-type/ajax`, {
            contact_type: "completed"
        }).then((response) => {
            completedResult.innerHTML = response.data.result
            btnCompleted.classList.remove("btn-loading")
        }).catch((error) => {
            console.error(error)
        })
    }

    async function syncWaiting() {
        await axios.post(`${URL}/admin/dash/contact-type/ajax`, {
            contact_type: "waiting"
        }).then((response) => {
            waitingResult.innerHTML = response.data.result
            btnWaiting.classList.remove("btn-loading")
        }).catch((error) => {
            console.error(error)
        })
    }

    async function syncInNegotiation() {
        await axios.post(`${URL}/admin/dash/contact-type/ajax`, {
            contact_type: "inNegotiation"
        }).then((response) => {
            inNegotiationResult.innerHTML = response.data.result
            btnInNegotiation.classList.remove("btn-loading")
        }).catch((error) => {
            console.error(error)
        })
    }

    async function syncLoss() {
        await axios.post(`${URL}/admin/dash/contact-type/ajax`, {
            contact_type: "loss"
        }).then((response) => {
            lossResult.innerHTML = response.data.result
            btnLoss.classList.remove("btn-loading")
        }).catch((error) => {
            console.error(error)
        })
    }

    async function syncFuture() {
        await axios.post(`${URL}/admin/dash/contact-type/ajax`, {
            contact_type: "future"
        }).then((response) => {
            futureResult.innerHTML = response.data.result
            btnFuture.classList.remove("btn-loading")
        }).catch((error) => {
            console.error(error)
        })
    }
})