CREATE FUNCTION addBattleCard(login VARCHAR(50), id INT, hpCard INT, damageCard INT, manaCard INT,
                              cardCard VARCHAR(300)) RETURNS BOOLEAN
BEGIN
    IF login = checkPlayer(login, id) THEN
        INSERT INTO battle_card(idBattle, player, hp, damage, mana, card) VALUE
            (id, login, hpCard, damageCard, manaCard, cardCard);
        RETURN TRUE;
    ELSE
        RETURN FALSE;
    END IF;
end;

CREATE FUNCTION checkPlayer(login VARCHAR(50), id INT)
    RETURNS VARCHAR(50)
BEGIN
    IF
            login in (
            SELECT battles.player1
            FROM battles
            WHERE battles.id = id
        ) THEN
        RETURN login;
    ELSEIF
            login in (
            SELECT battles.player2
            FROM battles
            WHERE battles.id = id
        ) THEN
        RETURN login;

    ELSE
        RETURN '';
    END IF;
END;

CREATE FUNCTION finishBattle(id INT) RETURNS BOOLEAN
BEGIN
    DELETE
    FROM battles
    WHERE battles.id = id;
    RETURN FALSE;
END;

# CREATE FUNCTION removeCard(idCard INT) RETURNS BOOLEAN
# BEGIN
# DELETE
# FROM battles
# WHERE battles.idCard = idCard;
# END;

CREATE FUNCTION changeCard(@idBattles INT, @login CHAR(50), @newHpCard INT, @previousHpCard INT, @damage INT, @mana INT,
                           @cardJson VARCHAR(1000))
    RETURN BOOLEAN
BEGIN
    set @id = (SELECT MIN(battle_card.idBattle)
               FROM battles
                        JOIN battle_card ON battles.id = battle_card.idBattle
               WHERE battles.id = @idBattles
                 and battle_card.player = @login
                 and battle_card.hp = @previousHpCard
                 and battle_card.damage = @damage
                 and battle_card.mana = @mana
    );

    IF @newHpCard < 0 THEN
        DELETE
        FROM battle_card
        WHERE battle_card.idCard = @id;
    ELSE
        UPDATE battle_card
        SET battle_card.hp   = @newHpCard,
            battle_card.card = @cardJson
        WHERE battle_card.idCard = @id;
    END IF;
END;

CREATE FUNCTION getCardByPlayer(idBattle INT, login VARCHAR(50)) return boolean
BEGIN

end;

SELECT battle_card.hp, battle_card.damage, battle_card.card
FROM battle_card
         JOIN battles b on b.id = battle_card.idBattle
WHERE player = 'User1'
  and idBattle = 3