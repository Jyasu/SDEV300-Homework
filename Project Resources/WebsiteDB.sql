CREATE TABLE Users (
username varchar(30) primary key,
password varchar(30),
email varchar(30)
);

CREATE TABLE Products (
productID int (5) primary key,
);

INSERT into Products (productID)
VALUES (1);

INSERT into Products (productID)
VALUES (2);

INSERT into Products (productID)
VALUES (3);

INSERT into Products (productID)
VALUES (4);

CREATE TABLE UserDetails (
fname varchar(30),
lname varchar(30),
street varchar(300),
city varchar(30),
usState varchar(30),
zip varchar(30),
phone varchar(30),
creditCard varchar(30),
creditType varchar(30),
expiration varchar(30),
purchased varchar(200),
username varchar(30) references Users(username)
);