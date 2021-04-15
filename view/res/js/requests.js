function sendData(data, callback) {
    const XHR = new XMLHttpRequest(), FD  = new FormData();

    for (name in data) {
        FD.append(name, data[name])
    }
    
    XHR.addEventListener('load', function(event) {
        console.log("Sending requests...")

        if (XHR.status != 200) {
            alert(`Error ${XHR.status}: ${XHR.statusText}`)
        }
        else {
            let responseObj = XHR.response
            callback(responseObj)
        }
    })
    
    XHR.open('POST', 'http://10.11.6.2:8080/test.php')
    XHR.send(FD);
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
            console.log((data))
        }
    )
}

function getCards() {
    sendData(
        {
            "json[player]": PLAYER_NAME
        },
        (data) => {
            // data = '{"player":"#PLAYER_2_NAME#","card":{"name":"Malekit","health":"3","attack":"4","mana":"3","img":".\/res\/img\/cards\/malekith.jpg"}}'

            let json = JSON.parse(data)

            if (json["player"] == document.querySelector("div#opponent div#name p").innerHTML) {
                document.querySelector("div#opponent div#field").insertAdjacentHTML("beforeend", "<div id='card" + CARD_ID + "' class='card' style='background: url(./res/img/card.png), url(" + json["card"]["img"] + "), rgba(0, 0, 0, 0.562)'><div class='row'><p class='health'><img src='./res/img/heart.png'><span id='health'>" + json["card"]["health"] + "</span></p><p class='attack'><img src='./res/img/sword.png'><span id='attack'>" + json["card"]["attack"] + "</span></p><p class='mana'><img src='./res/img/mana.png'><span id='mana'>" + json["card"]["mana"] + "</span></p></div><p class='name'>" + json["card"]["name"] + "</p></div>")

                CARD_ID += 1
    
                // MANA_THIS_MOVE -= cost
    
                // document.querySelector("div#timer span.mana span#mana").innerHTML = MANA_THIS_MOVE
            }
        }
    )
}
