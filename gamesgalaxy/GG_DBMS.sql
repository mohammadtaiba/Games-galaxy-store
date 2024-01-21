DROP DATABASE IF EXISTS GG_DBMS;
CREATE DATABASE IF NOT EXISTS GG_DBMS
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;
USE GG_DBMS;

DROP TABLE IF EXISTS user;
CREATE TABLE IF NOT EXISTS user
(
	user_id			INTEGER		NOT NULL AUTO_INCREMENT,
	user_name		VARCHAR(25)	NOT NULL,
	user_email		VARCHAR(50)	NOT NULL,
	user_password	VARCHAR(50)	NOT NULL,
	CONSTRAINT user_pk PRIMARY KEY (user_id)
);




DROP TABLE IF EXISTS user_authority;
CREATE TABLE IF NOT EXISTS user_authority
(
    user_authority_id  INTEGER         NOT NULL AUTO_INCREMENT,
    user_id            INTEGER         NOT NULL,
    role               VARCHAR(25)     NOT NULL,
    create_user        BOOLEAN         DEFAULT FALSE,
    change_user        BOOLEAN         DEFAULT FALSE,
    delete_user        BOOLEAN         DEFAULT FALSE,
    create_game        BOOLEAN         DEFAULT FALSE,
    change_game        BOOLEAN         DEFAULT FALSE,
    delete_game        BOOLEAN         DEFAULT FALSE,
    CONSTRAINT user_authority_pk PRIMARY KEY (user_authority_id)
);

DROP TABLE IF EXISTS user_address;
CREATE TABLE IF NOT EXISTS user_address
(
	address_id				INTEGER		NOT NULL AUTO_INCREMENT,
	user_id					INTEGER		NOT NULL,
	address_street			VARCHAR(50),
	address_street_number	INTEGER,
	address_city			VARCHAR(25),
	address_postalcode		INTEGER,
	CONSTRAINT address_pk PRIMARY KEY (address_id)
);

DROP TABLE IF EXISTS category;
CREATE TABLE IF NOT EXISTS category
(
	category_id				INTEGER			NOT NULL AUTO_INCREMENT,
	game_id                 INTEGER         NOT NULL,
    Strategie               BOOL,
    Action                  BOOL,
    Shooter                 BOOL,
    RPG                     BOOL,
    Simulation              BOOL,
	CONSTRAINT category_pk PRIMARY KEY (category_id)
);

DROP TABLE IF EXISTS game;
CREATE TABLE IF NOT EXISTS game
(
	game_id				INTEGER			        NOT NULL AUTO_INCREMENT,
	game_platform		VARCHAR(25)		        NOT NULL,
	game_name			VARCHAR(50)		        NOT NULL,
	game_price			VARCHAR(10)			NOT NULL,
	game_description	VARCHAR(500)	        NOT NULL,
	game_key			VARCHAR(50)		        NOT NULL,
	CONSTRAINT 	game_pk PRIMARY KEY (game_id)
);

DROP TABLE IF EXISTS wishlist;
CREATE TABLE IF NOT EXISTS wishlist
(
	wishlist_id	INTEGER	NOT NULL AUTO_INCREMENT,
	game_id		INTEGER	NOT NULL,
	user_id		INTEGER	NOT NULL,
	CONSTRAINT wishlist_pk PRIMARY KEY (wishlist_id)
);

DROP TABLE IF EXISTS cart_item;
CREATE TABLE IF NOT EXISTS cart_item
(
	cart_id				INTEGER	NOT NULL AUTO_INCREMENT,
	game_id				INTEGER	NOT NULL,
	user_id				INTEGER	NOT NULL,
	CONSTRAINT cart_pk PRIMARY KEY (cart_id)
);

DROP TABLE IF EXISTS order_data;
CREATE TABLE IF NOT EXISTS order_data
(
	order_id	    INTEGER	        NOT NULL AUTO_INCREMENT,
	user_id		    INTEGER	        NOT NULL,
	order_total	    DECIMAL(10, 2)	NOT NULL,
	order_date	    DATE	        NOT NULL,
    payment_method  VARCHAR(25)      NOT NULL,
	CONSTRAINT order_pk PRIMARY KEY (order_id)
);

DROP TABLE IF EXISTS order_items;
CREATE TABLE IF NOT EXISTS order_items
(
	order_items_id	INTEGER	NOT NULL AUTO_INCREMENT,
	order_id		INTEGER	NOT NULL,
	game_id			INTEGER NOT NULL,
	CONSTRAINT order_items_pk PRIMARY KEY (order_items_id)
);


ALTER TABLE user_authority
    ADD CONSTRAINT user_authority_fk1 FOREIGN KEY (user_id)
        REFERENCES user (user_id);

ALTER TABLE user_address
ADD CONSTRAINT user_address_fk1 FOREIGN KEY (user_id)
REFERENCES user (user_id);

ALTER TABLE category
ADD CONSTRAINT category_fk1 FOREIGN KEY (game_id)
REFERENCES game (game_id);

ALTER TABLE wishlist
ADD CONSTRAINT wishlist_fk1 FOREIGN KEY (game_id)
REFERENCES game (game_id),
ADD CONSTRAINT wishlist_fk2 FOREIGN KEY (user_id)
REFERENCES user (user_id);

ALTER TABLE cart_item
ADD CONSTRAINT cart_fk1	FOREIGN KEY	(game_id)
REFERENCES game (game_id),
ADD CONSTRAINT cart_fk2	FOREIGN	KEY	(user_id)
REFERENCES user	(user_id);


ALTER TABLE order_data
ADD CONSTRAINT order_fk1 FOREIGN KEY (user_id)
REFERENCES user (user_id);

ALTER TABLE order_items
ADD CONSTRAINT order_items_fk1 FOREIGN KEY (order_id)
REFERENCES order_data (order_id),
ADD CONSTRAINT order_items_fk2 FOREIGN KEY (game_id)
REFERENCES game (game_id);

-- Testdaten Steam
INSERT INTO game (game_platform, game_name, game_price, game_description, game_key)
VALUES ('Steam', 'Grim Dawn', '24,99', 'Enter an apocalyptic fantasy world where humanity is on the brink of extinction, iron is valued above gold and trust is hard earned. This ARPG features complex character development, hundreds of unique items, crafting and quests with choice & consequence.', 'GD-XXX-XX');

SET @last_game_id = LAST_INSERT_ID();

INSERT INTO category (game_id, Strategie, Action, Shooter, RPG, Simulation)
VALUES (@last_game_id, 0, 1, 0, 1, 0);

INSERT INTO game (game_platform, game_name, game_price, game_description, game_key)
VALUES ('Steam', 'Disgaea 5 Complete', '39,99', 'The nefarious Overlord Void Dark seeks to enslave countless Netherworlds...and only the young demon Killia can stop him! Assemble your tenacious army of rebels and unleash vengeance in this hell-raising adventure! The stakes are high, the damage cap is higher, and the destruction is limitless!', 'D5C-XXX-XX');

SET @last_game_id = LAST_INSERT_ID();

INSERT INTO category (game_id, Strategie, Action, Shooter, RPG, Simulation)
VALUES (@last_game_id, 1, 0, 0, 1, 0);

INSERT INTO game (game_platform, game_name, game_price, game_description, game_key)
VALUES ('Steam', 'Borderlands 2', '29,99', 'A new era of shoot and loot is about to begin. Play as one of four new vault hunters facing off against a massive new world of creatures, psychos and the evil mastermind, Handsome Jack. Make new friends, arm them with a bazillion weapons and fight alongside them in 4 player co-op on a relentless quest for revenge and redemption across the undiscovered and unpredictable living planet.', 'BL2-XXX-XX');

SET @last_game_id = LAST_INSERT_ID();

INSERT INTO category (game_id, Strategie, Action, Shooter, RPG, Simulation)
VALUES (@last_game_id, 0, 1, 1, 1, 0);

INSERT INTO game (game_platform, game_name, game_price, game_description, game_key)
VALUES ('Steam', 'Euro Truck Simulator 2', '19,99', 'Travel across Europe as king of the road, a trucker who delivers important cargo across impressive distances! With dozens of cities to explore, your endurance, skill and speed will all be pushed to their limits.', 'ETS2-XXX-XX');

SET @last_game_id = LAST_INSERT_ID();

INSERT INTO category (game_id, Strategie, Action, Shooter, RPG, Simulation)
VALUES (@last_game_id, 0, 0, 0, 0, 1);

-- Testdaten Epic Games
INSERT INTO game (game_platform, game_name, game_price, game_description, game_key)
VALUES ('Epic Games', 'Avatar: Frontiers of Pandora', '69,99', 'In Avatar: Frontiers of Pandora™, you’ll embark on a journey across the open world of the never-before-seen Western Frontier. Reconnect with your lost heritage and discover what it means to become Na’vi as you join other clans to protect Pandora from the formidable forces of the RDA.', 'AFOP-XXX-XX');

SET @last_game_id = LAST_INSERT_ID();

INSERT INTO category (game_id, Strategie, Action, Shooter, RPG, Simulation)
VALUES (@last_game_id, 0, 1, 0, 0, 0);

INSERT INTO game (game_platform, game_name, game_price, game_description, game_key)
VALUES ('Epic Games', 'Dungeons 4', '49,99', 'Build a cozy and comfortable Dungeon to suit your creatures’ needs and rule over them, then send them out into the Overworld to kindly remind the good people living there that the Absolute Evil rules over their lands.', 'D4-XXX-XX');

SET @last_game_id = LAST_INSERT_ID();

INSERT INTO category (game_id, Strategie, Action, Shooter, RPG, Simulation)
VALUES (@last_game_id, 1, 0, 0, 0, 1);

INSERT INTO game (game_platform, game_name, game_price, game_description, game_key)
VALUES ('Epic Games', 'Witchfire', '35,99', 'Armed with strange weapons and forbidden pagan magic, hunt a powerful witch holding the key to your salvation. Witchfire is a dark fantasy first person shooter from the creators of Painkiller, Bulletstorm, and The Vanishing of Ethan Carter.', 'WF-XXX-XX');

SET @last_game_id = LAST_INSERT_ID();

INSERT INTO category (game_id, Strategie, Action, Shooter, RPG, Simulation)
VALUES (@last_game_id, 0, 0, 1, 0, 0);

INSERT INTO game (game_platform, game_name, game_price, game_description, game_key)
VALUES ('Epic Games', 'Mass Effect Legendary Edition', '59,99', 'One person is all that stands between humanity and the greatest threat it’s ever faced. Relive the legend of Commander Shepard in the highly acclaimed Mass Effect trilogy with the Mass Effect™ Legendary Edition. Includes single-player base content and over 40 DLC from Mass Effect, Mass Effect 2, and Mass Effect 3 games, including promo weapons, armors, and packs – remastered and optimized for 4K Ultra HD.', 'MELE-XXX-XX');

SET @last_game_id = LAST_INSERT_ID();

INSERT INTO category (game_id, Strategie, Action, Shooter, RPG, Simulation)
VALUES (@last_game_id, 0, 0, 1, 1, 0);

-- Testdaten Battle.net
INSERT INTO game (game_platform, game_name, game_price, game_description, game_key)
VALUES ('Battle.net', 'Call of Duty: Modern Warfare III', '69,99', 'In the direct sequel to the record-breaking Call of Duty®: Modern Warfare® II, Captain Price and Task Force 141 face off against the ultimate threat. The ultranationalist war criminal Vladimir Makarov is extending his grasp across the world causing Task Force 141 to fight like never before.', 'MW3-XXX-XX');

SET @last_game_id = LAST_INSERT_ID();

INSERT INTO category (game_id, Strategie, Action, Shooter, RPG, Simulation)
VALUES (@last_game_id, 0, 0, 1, 0, 0);

INSERT INTO game (game_platform, game_name, game_price, game_description, game_key)
VALUES ('Battle.net', 'Warcraft III: Reforged', '29,99', 'Warcraft III: Reforged is a stunning reimagining of the revolutionary real-time strategy game that laid the foundation for Azeroth’s most epic stories. It is a remake in the truest sense, featuring a thorough visual overhaul, a suite of contemporary social and matchmaking features, and more. Command the Night Elves, Undead, Orcs, and Humans as alliances shift and armies clash in this timeless real-time strategy game.', 'WC3R-XXX-XX');

SET @last_game_id = LAST_INSERT_ID();

INSERT INTO category (game_id, Strategie, Action, Shooter, RPG, Simulation)
VALUES (@last_game_id, 1, 0, 0, 0, 0);

INSERT INTO game (game_platform, game_name, game_price, game_description, game_key)
VALUES ('Battle.net', 'Diablo III', '19,99', 'Twenty years have passed since the Prime Evils were defeated and banished from the world of Sanctuary. Now, you must return to where it all began—the town of Tristram—and investigate rumors of a fallen star, for this is the first sign of evil’s rebirth, and an omen that the End Times have begun.', 'D3-XXX-XX');

SET @last_game_id = LAST_INSERT_ID();

INSERT INTO category (game_id, Strategie, Action, Shooter, RPG, Simulation)
VALUES (@last_game_id, 0, 1, 0, 1, 0);

INSERT INTO game (game_platform, game_name, game_price, game_description, game_key)
VALUES ('Battle.net', 'World of Warcraft', '10,99', 'Join millions of players and enter a world of myth, magic, and endless adventure. With a single subscription, you can access World of Warcraft and WoW Classic, including Wrath of the Lich King Classic, Season of Discovery, and Hardcore Realms.', 'WOW-XXX-XX');

SET @last_game_id = LAST_INSERT_ID();

INSERT INTO category (game_id, Strategie, Action, Shooter, RPG, Simulation)
VALUES (@last_game_id, 0, 0, 0, 1, 1);


-- Testdaten `user` Tabelle
INSERT INTO user (user_name, user_email, user_password)
    VALUES ('AdminUser', 'admin@example.com', 'adminpass');
INSERT INTO user (user_name, user_email, user_password)
    VALUES ('RegularUser', 'user@example.com', 'userpass');
INSERT INTO user (user_name, user_email, user_password)
    VALUES ('VisitorUser', 'visitor@example.com', 'visitorpass');

-- Beispiel-Berechtigungen in der `user_authority` Tabelle
-- Angenommen, die IDs der Nutzer sind 1, 2 und 3 !!
INSERT INTO user_authority (user_id, role, create_user, change_user, delete_user, create_game, change_game, delete_game)
    VALUES (1, 'admin', TRUE, TRUE, TRUE, TRUE, TRUE, TRUE);
INSERT INTO user_authority (user_id, role, create_user, change_user, delete_user, create_game, change_game, delete_game)
    VALUES (2, 'user', FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);
INSERT INTO user_authority (user_id, role, create_user, change_user, delete_user, create_game, change_game, delete_game)
    VALUES (3, 'visitor', FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);