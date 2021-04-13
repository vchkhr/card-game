const TIME_FOR_ONE_MOVE = 3
const MANA_MAX = 6
const GAME_MODE = 1 // 0 - multiplayer
                    // 1 - two players on one computer
                    // 2 - one player with a bot

const CARDS_AT_START = 3
const CARDS_MAX = 10
const CARDS_FIELD_MAX = CARDS_MAX
let CARDS_PLAYER = CARDS_AT_START
let CARDS_OPPONENT = CARDS_AT_START
let CARDS_FIELD_PLAYER = 0
let CARDS_FIELD_OPPONENT = 0

let CURRENT_PLAYER = 0

let MANA = 0
let MANA_THIS_MOVE = MANA
let GAME_TIME

let CARD_ID = 0
let CARDS_LIBRARY = [
    {
        name: "A",
        image: "",
        health: 2, 
        attack: 2,
        mana: 1
    },
    {
        name: "B", 
        image: "",
        health: 5, 
        attack: 5,
        mana: 2
    }
]

let useCard = function(e) {
    const cost = this.querySelector("p.mana span#mana").innerHTML

    if (GAME_MODE != 1 && CURRENT_PLAYER != 0) {
        return
    }

    if (CURRENT_PLAYER == 0) {
        if (cost > MANA_THIS_MOVE || CARDS_FIELD_PLAYER >= CARDS_FIELD_MAX) {
            return
        }

        document.querySelector("div#player div#field").insertAdjacentHTML("beforeend", "<div class='card'>" + this.innerHTML + "</div>")

        document.querySelector("div#player div#cards div.card#" + this.id).remove()

        MANA_THIS_MOVE -= cost

        document.querySelector("div#timer span.mana span#mana").innerHTML = MANA_THIS_MOVE

        CARDS_PLAYER -= 1
        CARDS_FIELD_PLAYER += 1
    }
    else {
        if (cost > MANA_THIS_MOVE || CARDS_FIELD_OPPONENT >= CARDS_FIELD_MAX) {
            return
        }

        document.querySelector("div#opponent div#field").insertAdjacentHTML("beforeend", "<div class='card'>" + this.innerHTML + "</div>")

        document.querySelector("div#opponent div#cards div.card#" + this.id).remove()

        MANA_THIS_MOVE -= cost

        document.querySelector("div#timer span.mana span#mana").innerHTML = MANA_THIS_MOVE

        CARDS_OPPONENT -= 1
        CARDS_FIELD_OPPONENT += 1
    }
}

function updateCardsActions() {
    document.querySelectorAll("div#cards div.card").forEach(function(e) {
        e.removeEventListener("click", useCard)
    })

    if (CURRENT_PLAYER == 0) {
        document.querySelectorAll("div#player div#cards div.card").forEach(function(e) {
            e.addEventListener("click", useCard)
        })
    }
    else  if (GAME_MODE == 1) {
        document.querySelectorAll("div#opponent div#cards div.card").forEach(function(e) {
            e.addEventListener("click", useCard)
        })
    }
}

function makeDamage() {
    if (CURRENT_PLAYER == 0) {
        // let formdata = new FormData()
        // formdata.append("player", "player")
        // formdata.append("card", this.id.replace("card", ""))

        // let ajax = new XMLHttpRequest()
        // ajax.open("POST", "index.php", true)
        // ajax.send(formdata)

        document.querySelectorAll("div#player div#field div.card").forEach(function(e) {
            damage = e.querySelector("p.attack span#attack").innerHTML

            for (let i = damage; i > 0;) {
                if (document.querySelectorAll("div#opponent div#field div.card").length > 0) {
                    let opCard = document.querySelector("div#opponent div#field div.card")
                    let opCardHealth = opCard.querySelector("p.health span#health")

                    if (opCardHealth.innerHTML <= i) {
                        i -= opCardHealth.innerHTML

                        opCard.remove()
                    }
                    else {
                        opCardHealth.innerHTML -= i

                        i = 0
                    }
                }
                else {
                    let opHealth = document.querySelector("div#opponent div#health span")

                    opHealth.innerHTML = opHealth.innerHTML - 1
                    i--

                    if (opHealth.innerHTML <= 0) {
                        document.querySelector("div#opponent img").src = "./res/img/lose.gif"
                        document.querySelector("div#player img").src = "./res/img/win.gif"

                        setTimeout(function() {
                            document.querySelector("div#game-over").classList.remove("hidden")
                            document.querySelector("div#game-over p.win").classList.remove("hidden")

                            document.querySelector("div#opponent").classList.add("hidden")
                            document.querySelector("div#timer").classList.add("hidden")
                            document.querySelector("div#player").classList.add("hidden")
                        }, 2000)
                    }
                }
            }
        })
    }
    else {
        document.querySelectorAll("div#opponent div#field div.card").forEach(function(e) {
            damage = e.querySelector("p.attack span#attack").innerHTML

            for (let i = damage; i > 0;) {
                if (document.querySelectorAll("div#player div#field div.card").length > 0) {
                    let opCard = document.querySelector("div#player div#field div.card")
                    let opCardHealth = opCard.querySelector("p.health span#health")

                    if (opCardHealth.innerHTML <= i) {
                        i -= opCardHealth.innerHTML

                        opCard.remove()
                    }
                    else {
                        opCardHealth.innerHTML -= i

                        i = 0
                    }
                }
                else {
                    let opHealth = document.querySelector("div#player div#health span")

                    opHealth.innerHTML = opHealth.innerHTML - 1
                    i--

                    if (opHealth.innerHTML <= 0) {
                        document.querySelector("div#opponent img").src = "./res/img/win.gif"
                        document.querySelector("div#player img").src = "./res/img/lose.gif"

                        setTimeout(function() {
                            document.querySelector("div#game-over").classList.remove("hidden")
                            document.querySelector("div#game-over p.lose").classList.remove("hidden")
    
                            document.querySelector("div#player").classList.add("hidden")
                            document.querySelector("div#timer").classList.add("hidden")
                            document.querySelector("div#opponent").classList.add("hidden")
                        }, 2000)
                    }
                }
            }
        })
    }
}

function changePlayer() {
    makeDamage()

    if (CURRENT_PLAYER == 0) {
        document.querySelector("div#timer span.move").classList.add("hidden")
        CURRENT_PLAYER = 1
    }
    else {
        document.querySelector("div#timer span.move").classList.remove("hidden")
        CURRENT_PLAYER = 0

        if (CARDS_PLAYER <= CARDS_MAX - 1) {
            selectRandomCard("player")

            CARDS_PLAYER += 1
        }

        if (CARDS_OPPONENT <= CARDS_MAX - 1) {
            selectRandomCard("opponent")

            CARDS_OPPONENT += 1
        }
    }

    updateMana()

    clearInterval(GAME_TIME)
    gameTimer()

    updateCardsActions()
}

function updateMana() {
    if (CURRENT_PLAYER == 0) {
        MANA += 1
    }

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

    GAME_TIME = setInterval(function() {
        time -= 1
        updateGameTimer(time)

        if (time <= 0) {
            changePlayer()
        }
    }, 1000)
}

function selectRandomCard(whom) {
    const card = CARDS_LIBRARY[Math.floor(Math.random() * CARDS_LIBRARY.length)];

    document.querySelector("div#" + whom + " div#cards").insertAdjacentHTML("beforeend", '<div id="card' + CARD_ID + '" class="card"><p class="name">' + card['name'] + '</p><div class="row"><p class="health"><img src="./res/img/heart.gif"> <span id="health">' + card['health'] + '</span></p><p class="attack"><img src="./res/img/sword.png"> <span id="attack">' + card['attack'] + '</span></p><p class="mana"><img src="./res/img/mana.png"> <span id="mana">' + card['mana'] + '</span></p></div></div>')

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

setTimeout(function() {
    document.querySelector("div#coin").classList.add("hidden")
    document.querySelector("div#timer").classList.remove("hidden")
    document.querySelector("div#opponent").classList.remove("hidden")
    document.querySelector("div#player").classList.remove("hidden")

    if (Math.floor(Math.random() * 2) == 1) {
        changePlayer()
    }
    else {
        gameTimer()
    }

    updateMana()
    cardsAtStart()
}, 1)

