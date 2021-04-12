const TIME_FOR_ONE_MOVE = 1
const MANA_MAX = 6

const CARDS_AT_START = 3
const CARDS_MAX = 10
const CARDS_FIELD_MAX = CARDS_MAX
let CARDS_PLAYER = CARDS_AT_START
let CARDS_FIELD_PLAYER = 0

let CURRENT_PLAYER = 0

let MANA = 0
let MANA_THIS_MOVE = MANA

let CARD_ID = 0
let CARDS_LIBRARY = [
    {
        name: "A", 
        health: 10, 
        attack: 10,
        mana: 1
    },
    {
        name: "B", 
        health: 5, 
        attack: 5,
        mana: 2
    }
]

let useCard = function(e) {
    const cost = this.querySelector("p.mana span#mana").innerHTML

    if (CURRENT_PLAYER != 0 || cost > MANA_THIS_MOVE || CARDS_FIELD_PLAYER >= CARDS_FIELD_MAX) {
        return
    }

    document.querySelector("div#player div#field").insertAdjacentHTML("beforeend", "<div class='card'>" + this.innerHTML + "</div>")

    document.querySelector("div#player div#cards div.card#" + this.id).remove()

    MANA_THIS_MOVE -= cost

    document.querySelector("div#timer span.mana span#mana").innerHTML = MANA_THIS_MOVE

    CARDS_PLAYER -= 1
    CARDS_FIELD_PLAYER += 1

    let formdata = new FormData()
    formdata.append("player", "player")
    formdata.append("card", this.id.replace("card", ""))

    let ajax = new XMLHttpRequest()
    ajax.open("POST", "index.php", true)
    ajax.send(formdata)
}

function updateCardsActions() {
    document.querySelectorAll("div#player div#cards div.card").forEach(function(e) {
        e.removeEventListener("click", useCard)
    })

    document.querySelectorAll("div#player div#cards div.card").forEach(function(e) {
        e.addEventListener("click", useCard)
    })
}

function changePlayer() {
    if (CURRENT_PLAYER == 0) {
        document.querySelector("div#timer span.move").classList.add("hidden")
        CURRENT_PLAYER = 1
    }
    else {
        document.querySelector("div#timer span.move").classList.remove("hidden")
        CURRENT_PLAYER = 0
        
        updateMana()

        if (CARDS_PLAYER <= CARDS_MAX) {
            selectRandomCard("player")

            CARDS_PLAYER += 1
        }
    }

    gameTimer()
}

function updateMana() {
    MANA += 1

    if (MANA >= MANA_MAX) {
        MANA = MANA_MAX
    }

    MANA_THIS_MOVE = MANA

    document.querySelector("div#timer span#mana").innerHTML = MANA
}


function updateGameTimer(time) {
    document.querySelector("div#timer span#timer").innerHTML = (time - 1)
}

function gameTimer() {
    let time = TIME_FOR_ONE_MOVE
    updateGameTimer(time)

    let gameTime = setInterval(function() {
        time -= 1
        updateGameTimer(time)

        if (time <= 0) {
            clearInterval(gameTime)

            changePlayer()
        }
    }, 1000)
}

function selectRandomCard(whom) {
    const card = CARDS_LIBRARY[Math.floor(Math.random() * CARDS_LIBRARY.length)];

    document.querySelector("div#" + whom + " div#cards").insertAdjacentHTML("beforeend", '<div id="card' + CARD_ID + '" class="card"><p class="name">' + card['name'] + '</p><div class="row"><p class="health">HEALTH: <span id="health">' + card['health'] + '</span></p><p class="attack">ATTACK: <span id="attack">' + card['attack'] + '</span></p><p class="mana">MANA: <span id="mana">' + card['mana'] + '</span></p></div></div>')

    CARD_ID += 1

    updateCardsActions()
}

function cardsAtStart() {
    for (let i = 0; i < CARDS_AT_START; i++) {
        selectRandomCard("player")
    }

    for (let i = 0; i < CARDS_AT_START; i++) {
        selectRandomCard("opponent")
    }
}

updateMana()
gameTimer()
cardsAtStart()
 