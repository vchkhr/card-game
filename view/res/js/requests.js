const URL = "http://10.11.6.2:8080/view/index.php"

function sendData(data, callback) {
    const XHR = new XMLHttpRequest(), FD  = new FormData();

    for (name in data) {
        FD.append(name, data[name])
    }
    
    XHR.addEventListener('load', function(event) {
        console.log("Sending card...")

        if (XHR.status != 200) {
            alert(`Error ${XHR.status}: ${XHR.statusText}`)
        }
        else {
            let responseObj = XHR.response
            callback(responseObj)
        }
    })
    
    XHR.open('POST', URL)
    XHR.send(FD);
}

function whoIsFirst() {
    sendData(
        {
            "json[whoIsFirst]": PLAYER_NAME
        },
        (data) => {
            if (data == PLAYER_NAME) {
                FIRST_PLAYER = true
            }
            else {
                FIRST_PLAYER = false
            }
        }
    )
}

function sendCard(card) {
    sendData(
        {
            "json[player]": PLAYER_NAME,
            "json[card][name]": document.querySelector("div#" + card + " p.name").innerHTML,
            "json[card][health]": document.querySelector("div#" + card + " span#health").innerHTML,
            "json[card][attack]": document.querySelector("div#" + card + " span#attack").innerHTML,
            "json[card][mana]": document.querySelector("div#" + card + " span#mana").innerHTML,
            "json[card][img]": document.querySelector("div#" + card).style.background.split('url("')[2].split('"')[0]
        },
        (data) => {
            console.log("Thrown card sent")
        }
    )
}

function getCards() {
    console.log("Getting cards...")

    sendData(
        {
            "json[player]": document.querySelector("div#player div#name p").innerHTML
        },
        (data) => {
            // data = '[{"player":"#PLAYER_2_NAME#","card":{"name":"Malekit","health":"3","attack":"4","mana":"3","img":".\/res\/img\/cards\/malekith.jpg"}}]'

            let json = JSON.parse(data)

            for (let i in json) {
                let js = JSON.parse(json[i])

                document.querySelector("div#opponent div#field").insertAdjacentHTML("beforeend", "<div id='card" + CARD_ID + "' class='card' style='background: url(./res/img/card.png), url(" + js["img"] + "), rgba(0, 0, 0, 0.562)'><div class='row'><p class='health'><img src='./res/img/heart.png'><span id='health'>" + js["health"] + "</span></p><p class='attack'><img src='./res/img/sword.png'><span id='attack'>" + js["attack"] + "</span></p><p class='mana'><img src='./res/img/mana.png'><span id='mana'>" + js["mana"] + "</span></p></div><p class='name'>" + js["name"] + "</p></div>")

                if (document.querySelector("div#opponent div#cards div.card") != null) {
                    document.querySelector("div#opponent div#cards div.card").remove()
                }

                CARD_ID += 1

                // MANA_THIS_MOVE -= cost

                // document.querySelector("div#timer span.mana span#mana").innerHTML = MANA_THIS_MOVE
            }
        }
    )
}

function sendGameOver() {
    sendData(
        {
            "json[gameOver]": document.querySelector("div#player div#name p").innerHTML
            // "json[gameOverOpponent]": document.querySelector("div#opponent div#name p").innerHTML
        },
        (data) => {
            console.log("Game over send")
        }
    )
}