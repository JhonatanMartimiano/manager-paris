$(window).on("load", function (){
    let Ajax = new AjaxClass()
    let selectState = $(".selectState")

    selectState.change(function (){
        let state_id = selectState.val()
        let url = selectState.attr("data-url") + "/" + state_id
        let selectCity = $(".selectCity")

        Ajax.post(url, "",function (response){
            let arrOpt = []
            for (let i = 0; i < response.cities.length; i++) {
                arrOpt.push(`<option value="${response.cities[i].id}">${response.cities[i].name}</option>`)
            }
            selectCity.html(arrOpt)
        })
    })
})