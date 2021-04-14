CREATE DATABASE IF NOT EXISTS card_game;

USE card_game;
CREATE TABLE IF NOT EXISTS players
(
    login     VARCHAR(50) PRIMARY KEY NOT NULL,
    password  VARCHAR(60)             NOT NULL,
    fullName  VARCHAR(50),
    emailUser VARCHAR(60)             NOT NULL,
    isAdmin   BOOLEAN DEFAULT FALSE
);

CREATE TABLE IF NOT EXISTS battles
(
    id      INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    player1 VARCHAR(50)     NOT NULL,
    player2 VARCHAR(50)     NOT NULL,
    FOREIGN KEY (player1) REFERENCES players (login) ON DELETE CASCADE,
    FOREIGN KEY (player2) REFERENCES players (login) ON DELETE CASCADE,
    CHECK (NOT player1 = player2)
);

CREATE TABLE IF NOT EXISTS player_wait
(
    loginUser VARCHAR(50) NOT NULL UNIQUE,
    waitingTime INT,
    data VARCHAR(1000),
    FOREIGN KEY (loginUser) REFERENCES players (login) ON DELETE CASCADE
)

CREATE TABLE IF NOT EXISTS battle_card
(
    idCard   INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    idBattle INT                            NOT NULL,
    player   VARCHAR(50)                    NOT NULL,
    hp       INT                            NOT NULL,
    damage   INT                            NOT NULL,
    mana     INT                            NOT NULL,
    card     VARCHAR(1000)                  NOT NULL,
    FOREIGN KEY (idBattle) REFERENCES battles (id) ON DELETE CASCADE
-- #     FOREIGN KEY (player) REFERENCES battles (player1, player2) ON DELETE CASCADE
-- #     FOREIGN KEY (player) REFERENCES battles (player2) ON DELETE CASCADE
);