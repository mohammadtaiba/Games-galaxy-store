DROP DATABASE IF EXISTS GG_DBMS;
CREATE DATABASE IF NOT EXISTS GG_DBMS
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;
USE GG_DBMS;

DROP TABLE IF EXISTS user;
CREATE TABLE IF NOT EXISTS user
(
	user_id			INTEGER		NOT NULL,
	user_name		VARCHAR(25)	NOT NULL,
	user_email		VARCHAR(50)	NOT NULL,
	user_password	VARCHAR(50)	NOT NULL,
	user_authority	VARCHAR(25)	NOT NULL,
	CONSTRAINT user_pk PRIMARY KEY (user_id)
);

DROP TABLE IF EXISTS user_address;
CREATE TABLE IF NOT EXISTS user_address
(
	address_id				INTEGER		NOT NULL,
	user_id					INTEGER		NOT NULL,
	address_street			VARCHAR(50)	NOT NULL,
	address_street_number	INTEGER		NOT NULL,
	address_city			VARCHAR(25)	NOT NULL,
	address_postalcode		INTEGER		NOT NULL,
	CONSTRAINT address_pk PRIMARY KEY (address_id)
);

DROP TABLE IF EXISTS category;
CREATE TABLE IF NOT EXISTS category
(
	category_id				INTEGER			NOT NULL,
	category_name			VARCHAR(25)		NOT NULL,
	category_description	VARCHAR(250)	NOT NULL,
	CONSTRAINT category_pk PRIMARY KEY (category_id)
);

DROP TABLE IF EXISTS game;
CREATE TABLE IF NOT EXISTS game
(
	game_id				INTEGER			NOT NULL,
	category_id			INTEGER			NOT NULL,
	game_platform		VARCHAR(25)		NOT NULL,
	game_name			VARCHAR(50)		NOT NULL,
	game_price			DECIMAL			NOT NULL,
	game_description	VARCHAR(250)	NOT NULL,
	game_key			VARCHAR(50)		NOT NULL,
    game_cover          IMAGE           NOT NULL,
	CONSTRAINT 	game_pk PRIMARY KEY (game_id)
);

DROP TABLE IF EXISTS wishlist;
CREATE TABLE IF NOT EXISTS wishlist
(
	wishlist_id	INTEGER	NOT NULL,
	game_id		INTEGER	NOT NULL,
	user_id		INTEGER	NOT NULL,
	CONSTRAINT wishlist_pk PRIMARY KEY (wishlist_id)
);

DROP TABLE IF EXISTS session;
CREATE TABLE IF NOT EXISTS session
(
	session_id	INTEGER	NOT NULL,
	user_id		INTEGER	NOT NULL,
	CONSTRAINT session_pk PRIMARY KEY (session_id)
);

DROP TABLE IF EXISTS cart_item;
CREATE TABLE IF NOT EXISTS cart_item
(
	cart_id				INTEGER	NOT NULL,
	game_id				INTEGER	NOT NULL,
	user_id				INTEGER	NOT NULL,
	session_id			INTEGER	NOT NULL,
	cart_itemquantity	INTEGER	NOT NULL,
	CONSTRAINT cart_pk PRIMARY KEY (cart_id)
);

DROP TABLE IF EXISTS payment;
CREATE TABLE IF NOT EXISTS payment
(
	payment_id		INTEGER		NOT NULL,
	payment_amount 	DECIMAL		NOT NULL,
	payment_method	VARCHAR(50)	NOT NULL,
	paymen_status	VARCHAR(50)	NOT NULL,
	CONSTRAINT payment_pk PRIMARY KEY (payment_id)
);

DROP TABLE IF EXISTS order_data;					
CREATE TABLE IF NOT EXISTS order_data
(
	order_id	INTEGER	NOT NULL,
	user_id		INTEGER	NOT NULL,
	payment_id	INTEGER	NOT NULL,
	order_total	DECIMAL	NOT NULL,
	order_date	DATE	NOT NULL,
	CONSTRAINT order_pk PRIMARY KEY (order_id)
);

DROP TABLE IF EXISTS order_items;
CREATE TABLE IF NOT EXISTS order_items
(
	order_items_id	INTEGER	NOT NULL,
	order_id		INTEGER	NOT NULL,
	game_id			INTEGER NOT NULL,
	CONSTRAINT order_items_pk PRIMARY KEY (order_items_id)
);

CREATE USER 'ggadmin'@'localhost' IDENTIFIED BY 'ggpassword';
GRANT ALL PRIVILEGES ON gg_dbms.* TO 'ggadmin'@'localhost';


ALTER TABLE user_address
ADD CONSTRAINT user_address_fk1 FOREIGN KEY (user_id)
REFERENCES user (user_id);

ALTER TABLE game
ADD CONSTRAINT game_fk1 FOREIGN KEY (category_id) 
REFERENCES category (category_id);

ALTER TABLE wishlist
ADD CONSTRAINT wishlist_fk1 FOREIGN KEY (game_id)
REFERENCES game (game_id),
ADD CONSTRAINT wishlist_fk2 FOREIGN KEY (user_id)
REFERENCES user (user_id);

ALTER TABLE session
ADD CONSTRAINT session_fk1 FOREIGN KEY (user_id) 
REFERENCES user (user_id);

ALTER TABLE cart_item
ADD CONSTRAINT cart_fk1	FOREIGN KEY	(game_id)		
REFERENCES game (game_id),
ADD CONSTRAINT cart_fk2	FOREIGN	KEY	(user_id)
REFERENCES user	(user_id),
ADD	CONSTRAINT cart_fk3	FOREIGN	KEY	(session_id)	
REFERENCES session (session_id);

ALTER TABLE order_data
ADD CONSTRAINT order_fk1 FOREIGN KEY (user_id)
REFERENCES user (user_id),
ADD CONSTRAINT order_fk2 FOREIGN KEY (payment_id)
REFERENCES payment (payment_id);

ALTER TABLE order_items
ADD CONSTRAINT order_items_fk1 FOREIGN KEY (order_id)
REFERENCES order_data (order_id),
ADD CONSTRAINT order_items_fk2 FOREIGN KEY (game_id)
REFERENCES game (game_id);



