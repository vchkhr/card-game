const TIME_FOR_ONE_MOVE = 6
const TIME_UPDATE_EXTRA = 3
const MANA_MAX = 6
const GAME_MODE = 0 // 0 - two players on local network
                    // 1 - two players on one computer
                    // 2 - one player with bot

const CARDS_AT_START = 3
const CARDS_MAX = 10
const CARDS_FIELD_MAX = CARDS_MAX
let CARDS_PLAYER = CARDS_AT_START
let CARDS_OPPONENT = CARDS_AT_START
let CARDS_FIELD_PLAYER = 0
let CARDS_FIELD_OPPONENT = 0

let CURRENT_PLAYER = "player"
let PLAYER_NAME = document.querySelector("div#player div#name p").innerHTML
let OPPONENT_NAME = document.querySelector("div#opponent div#name p").innerHTML

let MANA = 1
let MANA_THIS_MOVE = MANA
let GAME_TIME

let CARD_ID = 0

let MOVES_COUNT = 0

let UPD_CARDS
