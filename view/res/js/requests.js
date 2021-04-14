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
            console.log((data))
        }
    )
}
