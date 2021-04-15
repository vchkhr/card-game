SELECT addBattleCard('User1', 2, 'qwerty');

SELECT addBattleCard('User1', 3, 20, 10, 2,'q');

SELECT checkPlayer('User1', 2);

SELECT finishBattle(2);

SELECT changeCard(idBattles INT, login CHAR(50), hpCard INT, cardJson VARCHAR(1000));

INSERT INTO player_wait(loginUser,data) VALUE
    ('user123', 'json');
