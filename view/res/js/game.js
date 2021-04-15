let useCard = function(e) {
    const cost = this.querySelector("p.mana span#mana").innerHTML

    if (GAME_MODE != 1 && CURRENT_PLAYER != "player") {
        return
    }

    if (CURRENT_PLAYER == "player") {
        if (cost > MANA_THIS_MOVE || CARDS_FIELD_PLAYER >= CARDS_FIELD_MAX) {
            return
        }

        CARDS_PLAYER -= 1
        CARDS_FIELD_PLAYER += 1
    
        sendCard(this.id)
    }
    else {
        if (cost > MANA_THIS_MOVE || CARDS_FIELD_OPPONENT >= CARDS_FIELD_MAX) {
            return
        }

        CARDS_OPPONENT -= 1
        CARDS_FIELD_OPPONENT += 1
    }

    document.querySelector("div#" + CURRENT_PLAYER + " div#field").insertAdjacentHTML("beforeend", "<div id='" + this.id + "' class='card'>" + this.innerHTML + "</div>")
    document.querySelector("div#" + CURRENT_PLAYER + " div#field div.card#" + this.id).style = this.style.cssText
    document.querySelector("div#" + CURRENT_PLAYER + " div#cards div.card#" + this.id).remove()

    MANA_THIS_MOVE -= cost

    document.querySelector("div#timer span.mana span#mana").innerHTML = MANA_THIS_MOVE
}

function updateCardsActions() {
    document.querySelectorAll("div#cards div.card").forEach(function(e) {
        e.removeEventListener("click", useCard)
    })

    if (CURRENT_PLAYER == "player") {
        document.querySelectorAll("div#player div#cards div.card").forEach(function(e) {
            e.addEventListener("click", useCard)
        })
    }
    else if (GAME_MODE == 1) {
        document.querySelectorAll("div#opponent div#cards div.card").forEach(function(e) {
            e.addEventListener("click", useCard)
        })
    }
}

function gameOver() {
    opponent = "player"
    if (CURRENT_PLAYER == "player") {
        opponent = "opponent"
    }

    let opHealth = document.querySelector("div#" + opponent + " div#health span")

    opHealth.innerHTML = opHealth.innerHTML - 1

    if (opHealth.innerHTML <= 0) {
        if (CURRENT_PLAYER == "player") {
            document.querySelector("div#" + opponent + " div#name img").src = "./res/img/lose.gif"
            document.querySelector("div#player div#name img").src = "./res/img/win.gif"
        }
        else {
            document.querySelector("div#opponent div#name img").src = "./res/img/win.gif"
            document.querySelector("div#player div#name img").src = "./res/img/lose.gif"
        }

        setTimeout(function() {
            document.querySelector("div#game-over").classList.remove("hidden")

            if (document.querySelector("div#player div#health span").innerHTML > 0) {
                document.querySelector("div#game-over .win").classList.remove("hidden")
            }
            else {
                document.querySelector("div#game-over .lose").classList.remove("hidden")
            }

            document.querySelector("div#player").classList.add("hidden")
            document.querySelector("div#opponent").classList.add("hidden")
            document.querySelector("div#timer").classList.add("hidden")

            document.querySelector("div#game-over span#moves-count").innerHTML = MOVES_COUNT

            clearInterval(GAME_TIME)
            clearInterval(UPD_CARDS)
        }, 2000)
    }
}

function makeDamage() {
    if (CURRENT_PLAYER == "player") {
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
                    gameOver()

                    i--
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
                    gameOver()

                    i--
                }
            }
        })
    }
}

function changePlayer() {
    makeDamage()

    if (CURRENT_PLAYER == "player") {
        startUpdateFunction()

        document.querySelector("div#timer span.move").classList.add("hidden")
        document.querySelector("div#timer span.mana").classList.add("hidden")
        document.querySelector("div#timer span.timer span#text").innerHTML = "WAIT"
        CURRENT_PLAYER = "opponent"
    }
    else {
        let upd_cards_delay = setInterval(function() {
            clearInterval(UPD_CARDS)
            clearInterval(upd_cards_delay)
        }, TIME_UPDATE_EXTRA * 1000)

        document.querySelector("div#timer span.move").classList.remove("hidden")
        document.querySelector("div#timer span.mana").classList.remove("hidden")
        document.querySelector("div#timer span.timer span#text").innerHTML = "TIME"
        CURRENT_PLAYER = "player"

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

    MOVES_COUNT++
}

function updateMana() {
    if (CURRENT_PLAYER == "player" && MOVES_COUNT > 0) {
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

    document.querySelector("div#" + whom + " div#cards").insertAdjacentHTML("beforeend", '<div id="card' + CARD_ID + '" class="card"><div class="row"><p class="health"><img src="./res/img/heart.png"> <span id="health">' + card['health'] + '</span></p><p class="attack"><img src="./res/img/sword.png"> <span id="attack">' + card['attack'] + '</span></p><p class="mana"><img src="./res/img/mana.png"> <span id="mana">' + card['mana'] + '</span></p></div><p class="name">' + card['name'] + '</p></div>')

    if ((GAME_MODE == 0 && whom == "player") || GAME_MODE == 1) {
        document.querySelector("div#card" + CARD_ID).style.background = "url(./res/img/card.png), url('" + card["image"] + "'), rgba(0, 0, 0, 0.562)"
    }

    if (GAME_MODE == 0 && whom == "opponent") {
        document.querySelectorAll("div#card" + CARD_ID + " p").forEach(function(e) {
            e.classList.add("hidden")
        })
    }

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

function startUpdateFunction() {
    UPD_CARDS = setInterval(function() {
        getCards()
    }, 1000)
}
