CREATE DATABASE IF NOT EXISTS sword;

USE sword;
CREATE TABLE IF NOT EXISTS users(
    login VARCHAR(30) PRIMARY KEY NOT NULL,
    password VARCHAR(60) NOT NULL,
    fullName VARCHAR(50),
    emailUser VARCHAR(50) NOT NULL,
    isAdmin BOOLEAN DEFAULT FALSE
);

INSERT INTO users(login,password, fullName,emailUser)
VALUE ('User0',123,'FullUserName','user0@sprint09.com');

INSERT INTO users(login,password, fullName,emailUser,isAdmin)
VALUE ('Admin','38','AdminName','*******@sprint09.com',true);


SELECT users.login
FROM users
WHERE users.login ='User0'

