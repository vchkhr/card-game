document.querySelectorAll("div#player div#cards div.card").forEach(function(e) {
    e.addEventListener("click", function() {
        document.querySelector("div#player div#field").insertAdjacentHTML("beforeend", "<div class='card'>" + e.innerHTML + "</div>")

        document.querySelector("div#player div#cards div.card#" + e.id).remove()

        var ajax = new XMLHttpRequest()
        var formdata = new FormData()
        formdata.append("player", "player")
        formdata.append("card", e.id.replace("card", ""))
        console.log(formdata)
        ajax.open("POST", "index.php", true)
        ajax.send(formdata)
    })
})

function gameTimer() {
    
}

gameTimer();
