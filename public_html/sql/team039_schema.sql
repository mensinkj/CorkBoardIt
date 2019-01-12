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