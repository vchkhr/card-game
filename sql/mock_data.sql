INSERT INTO players(login, password, fullName, emailUser) VALUE
    ('User1', 1, 'User', 'user0@sprint09.com'),
    ('User2', 1, 'User', 'user0@sprint09.com'),
    ('User3', 1, 'User', 'user0@sprint09.com'),
    ('User4', 1, 'User', 'user0@sprint09.com'),
    ('User5', 1, 'User', 'user0@sprint09.com'),
    ('User6', 1, 'User', 'user0@sprint09.com');

INSERT INTO battles(player1, player2) VALUE
--     ('User1', 'User2'),
    ('User3', 'User5');

INSERT INTO players(login, password, fullName, emailUser, isAdmin)
    VALUE ('Admin', '38', 'AdminName', '*******@sprint09.com', true);