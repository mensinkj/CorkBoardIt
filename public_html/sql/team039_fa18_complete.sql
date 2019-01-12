-- CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';
CREATE USER IF NOT EXISTS gatechUser@localhost IDENTIFIED BY 'gatech123';

DROP DATABASE IF EXISTS `cs6400_fa18_team043`; 
SET default_storage_engine=InnoDB;
SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE DATABASE IF NOT EXISTS cs6400_fa18_team043 
    DEFAULT CHARACTER SET utf8mb4 
    DEFAULT COLLATE utf8mb4_unicode_ci;
USE cs6400_fa18_team043;

GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO 'gatechUser'@'localhost';
GRANT ALL PRIVILEGES ON `gatechuser`.* TO 'gatechUser'@'localhost';
GRANT ALL PRIVILEGES ON `cs6400_fa18_team043`.* TO 'gatechUser'@'localhost';
FLUSH PRIVILEGES;

-- Tables 

CREATE TABLE `User` (
	userID int(8) unsigned NOT NULL AUTO_INCREMENT,
	email varchar(50) NOT NULL,
	pin varchar(4) NOT NULL,
	first_name varchar(50) NOT NULL,
	last_name varchar(50) NOT NULL,
	PRIMARY KEY (userID),
	UNIQUE KEY email (email)
);

CREATE TABLE Follows (
	followerID int(16) unsigned NOT NULL,
	followeeID int(16) unsigned NOT NULL,
	PRIMARY KEY (followerID,followeeID)
);

CREATE TABLE Corkboard (
	corkboardID int(16) unsigned NOT NULL AUTO_INCREMENT,
    title varchar(85) NOT NULL,
    userID int(16) unsigned NOT NULL,
	last_updated datetime NOT NULL,
	category_name varchar(50) NOT NULL,
	UNIQUE (title, userID),
    PRIMARY KEY (corkboardID)
);

CREATE TABLE PublicCorkboard (
	corkboardID int(16) unsigned NOT NULL,
	PRIMARY KEY (corkboardID)
);

CREATE TABLE PrivateCorkboard (
	corkboardID int(16) unsigned NOT NULL,
    `password` varchar(40) NOT NULL,
	PRIMARY KEY (corkboardID)
);

CREATE TABLE Watches (
	corkboardID int(16) unsigned NOT NULL,
    userID int(8) unsigned NOT NULL,
    PRIMARY KEY (corkboardID, userID)
);

CREATE TABLE Category (
	`name` varchar(50) NOT NULL,
	PRIMARY KEY (`name`)
);

CREATE TABLE PushPin (
	pushpinID int(16) unsigned NOT NULL AUTO_INCREMENT,
    pinned_date datetime NOT NULL,
    corkboardID int(16) unsigned NOT NULL,
    description varchar(200) NOT NULL,
    `host` varchar(50) NOT NULL,
    path varchar(120) NOT NULL,
    protocol varchar(10) NOT NULL,
    UNIQUE (pinned_date, corkboardID),
    PRIMARY KEY (pushpinID)
);

CREATE TABLE Tag (
	pushpinID int(16) unsigned NOT NULL,
    tag varchar(20) NOT NULL,
    PRIMARY KEY (pushpinID, tag)
);

CREATE TABLE Likes (
	pushpinID int(16) unsigned NOT NULL,
    userID int(16) unsigned NOT NULL,
    PRIMARY KEY (pushpinID, userID)
);

CREATE TABLE Comments (
	commentID int(16) unsigned NOT NULL AUTO_INCREMENT,
	date_added datetime NOT NULL,
    pushpinID  int(16) unsigned NOT NULL,
    userID int(16) unsigned NOT NULL,
    text varchar(200) NOT NULL,
    PRIMARY KEY (commentID)
);

-- Constraints   Foreign Keys: FK_ChildTable_childColumn_ParentTable_parentColumn

ALTER TABLE Follows
	ADD CONSTRAINT fk_Follows_followerID_User_userID FOREIGN KEY (followerID) REFERENCES User (userID) ON DELETE CASCADE,
	ADD CONSTRAINT fk_Follows_followeeID_User_userID FOREIGN KEY (followeeID) REFERENCES User (userID);

ALTER TABLE Corkboard
	ADD CONSTRAINT fk_Corkboard_UserID_User_userID FOREIGN KEY (UserID) REFERENCES User (userID),
	ADD CONSTRAINT fk_Corkboard_categoryName_Category_Name FOREIGN KEY (category_name) REFERENCES Category (`name`) ON UPDATE CASCADE;

ALTER TABLE PublicCorkboard
	ADD CONSTRAINT fk_PublicCorkboard_corkboardID_Corkboard_corkboardID FOREIGN KEY (corkboardID) REFERENCES Corkboard (corkboardID) ON DELETE CASCADE;
    
ALTER TABLE PrivateCorkboard
	ADD CONSTRAINT fk_PrivateCorkboard_corkboardID_Corkboard_corkboardID FOREIGN KEY (corkboardID) REFERENCES Corkboard (corkboardID) ON DELETE CASCADE;
    
ALTER TABLE Watches
	ADD CONSTRAINT fk_Watches_corkboardID_PublicCorkboard_corkboardID FOREIGN KEY (corkboardID) REFERENCES PublicCorkboard (corkboardID) ON DELETE CASCADE,
    ADD CONSTRAINT fk_Watches_userID_User_userID FOREIGN KEY (userID) REFERENCES User (userID) ON DELETE CASCADE;
	
ALTER TABLE PushPin
	ADD CONSTRAINT fk_PushPin_corkboardID_Corkboard_corkboardID FOREIGN KEY (corkboardID) REFERENCES Corkboard (corkboardID) ON DELETE CASCADE;

ALTER TABLE Tag
	ADD CONSTRAINT fk_Tag_pushpinID_PushPin_pushpinID FOREIGN KEY (pushpinID) REFERENCES PushPin (pushpinID);

ALTER TABLE Likes
	ADD CONSTRAINT fk_Likes_pushpinID_PushPin_pushpinID FOREIGN KEY (pushpinID) REFERENCES PushPin (pushpinID),
    ADD CONSTRAINT fk_Likes_userID_User_userID FOREIGN KEY (userID) REFERENCES User (userID) ON DELETE CASCADE;

ALTER TABLE Comments
	ADD CONSTRAINT fk_Comments_pushpinID_PushPin_pushpinID FOREIGN KEY (pushpinID) REFERENCES PushPin (pushpinID),
    ADD CONSTRAINT fk_Comments_userID_User_userID FOREIGN KEY (userID) REFERENCES User (userID);


-- Insert Test (seed) Data  
USE cs6400_fa18_team043;

-- Insert into User
INSERT INTO `User` (email, `pin`, first_name, last_name) VALUES('admin@gtonline.com', '1234', 'Michael', 'Crawley');
INSERT INTO `User` (email, `pin`, first_name, last_name) VALUES('dschrute@dundermifflin.com', '5678', 'Dwight', 'Schrute');
INSERT INTO `User` (email, `pin`, first_name, last_name) VALUES('gbluth@bluthco.com', '4444', '9101', 'Bluth');
INSERT INTO `User` (email, `pin`, first_name, last_name) VALUES('jhalpert@dundermifflin.com', '5639', 'Jim', 'Halpert');
INSERT INTO `User` (email, `pin`, first_name, last_name) VALUES('lfunke@bluthco.com', '2218', 'Lindsey', 'Funke');

-- Insert into Follows
INSERT INTO Follows (followerID, followeeID) VALUES((SELECT userID FROM `User` LIMIT 1), (SELECT userID FROM `User` LIMIT 1 OFFSET 1));
INSERT INTO Follows (followerID, followeeID) VALUES((SELECT userID FROM `User` LIMIT 1,1), (SELECT userID FROM `User` LIMIT 1 OFFSET 2));
INSERT INTO Follows (followerID, followeeID) VALUES((SELECT userID FROM `User` LIMIT 1,1), (SELECT userID FROM `User` LIMIT 1));

-- Insert into Category
INSERT INTO Category (`name`) VALUES ('Pets'), ('Home & Garden'), ('Travel'), ('Other'), ('People'), ('Photography'), ('Food & Drink'), ('Education'), ('Sports'), ('Architecture'), ('Art'), ('Technology');

-- Insert into Corkboard
INSERT INTO Corkboard (title, userID, last_updated, category_name) VALUES('Cats and their Antics', 001, DATE_SUB(NOW(), INTERVAL 5 hour), 'Pets');
INSERT INTO Corkboard (title, userID, last_updated, category_name) VALUES('Gardens I Love', 001, DATE_SUB(NOW(), INTERVAL 3 hour), 'Home & Garden');
INSERT INTO Corkboard (title, userID, last_updated, category_name) VALUES('Vacation Ideas', 001, DATE_SUB(NOW(), INTERVAL 4 hour), 'Travel');
INSERT INTO Corkboard (title, userID, last_updated, category_name) VALUES('Pools', 002, DATE_SUB(NOW(), INTERVAL 12 hour), 'Other');
INSERT INTO Corkboard (title, userID, last_updated, category_name) VALUES('Birthday Ideas', 002, DATE_SUB(NOW(), INTERVAL 34 hour), 'People');
INSERT INTO Corkboard (title, userID, last_updated, category_name) VALUES('Building Art', 001, DATE_SUB(NOW(), INTERVAL 22 hour), 'Photography');
INSERT INTO Corkboard (title, userID, last_updated, category_name) VALUES('Top Burgers', 004, DATE_SUB(NOW(), INTERVAL 14 hour), 'Food & Drink');

-- Insert into PublicCorkboard
INSERT INTO PublicCorkboard (CorkboardID) SELECT c.corkboardID FROM Corkboard c ORDER BY c.corkboardID ASC  LIMIT 5;

-- Insert into PrivateCorkboard
INSERT INTO PrivateCorkboard (CorkboardID, `password`) VALUES (006, 'prv1'),(007, 'prv2'); 

-- Insert into Watches
INSERT INTO Watches (CorkboardID, userID) VALUES (001, 003), (001, 004), (004, 001),(005, 002);

-- Insert into PushPin
INSERT INTO PushPin (pinned_date, CorkboardID, `description`, `host`, `path`, protocol) VALUES (DATE_SUB(NOW(), INTERVAL 3 hour), 001, 'black cat', 'valleypatriot.com', '/wp-content/uploads/2014/08/black-cat-outside.jpg', 'http');
INSERT INTO PushPin (pinned_date, CorkboardID, `description`, `host`, `path`, protocol) VALUES (DATE_SUB(NOW(), INTERVAL 2 hour), 001, 'golden cat', 'valleypatriot.com', '/wp-content/uploads/2018/03/Goldenboy1.jpg', 'http');
INSERT INTO PushPin (pinned_date, CorkboardID, `description`, `host`, `path`, protocol) VALUES (DATE_SUB(NOW(), INTERVAL 1 hour), 001, 'hungry cat', 'www.rd.com', '/wp-content/uploads/2016/04/01-cat-wants-to-tell-you-laptop.jpg', 'https');

INSERT INTO PushPin (pinned_date, CorkboardID, `description`, `host`, `path`, protocol) VALUES (DATE_SUB(NOW(), INTERVAL 1 hour), 002, 'overgrown garden', 'ennedygardencare.co.uk', '/wp-content/uploads/2015/06/glasgow_garden_tidyup.jpg', 'http');
INSERT INTO PushPin (pinned_date, CorkboardID, `description`, `host`, `path`, protocol) VALUES (DATE_SUB(NOW(), INTERVAL 2 hour), 002, 'nice tomato garden', 'lovebackyard.com', '/wp-content/uploads/2017/04/tomato-garden.jpg', 'https');

INSERT INTO PushPin (pinned_date, CorkboardID, `description`, `host`, `path`, protocol) VALUES (DATE_SUB(NOW(), INTERVAL 4 hour), 004, 'dirty pool...', 'recsports.ufl.edu', '/images/made/uploads/opportunities_and_programs/IMG_7328_800_567_80_s_c1.jpg', 'http');
INSERT INTO PushPin (pinned_date, CorkboardID, `description`, `host`, `path`, protocol) VALUES (DATE_SUB(NOW(), INTERVAL 3 hour), 004, 'lap pool.', 'oaklandnorth.net', '/wp-content/uploads/2011/07/pool-620x324.jpg', 'https');

-- Insert into Tag
INSERT INTO Tag (pushpinID, tag) VALUES (001, 'catz'),(001, 'kittens'), (002, 'catz'), (003, 'catz'), (004, 'bestgarden'), (004, 'earthy'), (005, 'earthy'), (006, 'h20'), (006, 'dirtypoolz'), (007, 'h20');

-- Insert into Likes
INSERT INTO Likes (pushpinID, userID) VALUES (001, 001), (001, 002), (002, 003), (003, 004), (004, 001), (004, 003), (005, 004), (006, 005), (006, 001), (007, 002);

-- Insert into Comments
INSERT INTO Comments (date_added, pushpinID, userID, `text`) VALUES(DATE_SUB(NOW(), INTERVAL 1 hour), 001, 001, 'nice cat indeed!');
INSERT INTO Comments (date_added, pushpinID, userID, `text`) VALUES(DATE_SUB(NOW(), INTERVAL 1 hour), 001, 002, 'very nice cat!');
INSERT INTO Comments (date_added, pushpinID, userID, `text`) VALUES(DATE_SUB(NOW(), INTERVAL 1 hour), 004, 001, 'this is def overgrown!');
INSERT INTO Comments (date_added, pushpinID, userID, `text`) VALUES(DATE_SUB(NOW(), INTERVAL 1 hour), 006, 003, 'Please, somebody clean this pool!');
