<?php

require "db_names.php";

// Database tables CREATE queries
define("USER_TABLE_CREATE_QUERY", "CREATE TABLE " . constant("DB_TABLE_USER") . " (
    username VARCHAR(255) NOT NULL,
    firstName VARCHAR(255),
    lastName VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(100),
	imgName VARCHAR(255),
	role ENUM('student', 'cc', 'admin','owner'),
	PRIMARY KEY (username)
)");

define("ADMIN_TABLE_CREATE_QUERY", "CREATE TABLE " . constant("DB_TABLE_ADMIN") . " (
    adminID INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(255),
	PRIMARY KEY (adminID),
	FOREIGN KEY (username) REFERENCES " . constant("DB_TABLE_USER") . "(username) ON DELETE CASCADE ON UPDATE CASCADE
)");

define("CC_TABLE_CREATE_QUERY", "CREATE TABLE " . constant("DB_TABLE_CC") . " (
    ccID INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(255),
	PRIMARY KEY (ccID),
	FOREIGN KEY (username) REFERENCES " . constant("DB_TABLE_USER") . "(username) ON DELETE CASCADE ON UPDATE CASCADE
)");

define("STUDENT_TABLE_CREATE_QUERY", "CREATE TABLE " . constant("DB_TABLE_STUDENT") . " (
    studentID INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(255),
	PRIMARY KEY (studentID),
	FOREIGN KEY (username) REFERENCES " . constant("DB_TABLE_USER") . "(username) ON DELETE CASCADE ON UPDATE CASCADE
)");

define("RESOURCE_CREATOR_TABLE_CREATE_QUERY", "CREATE TABLE " . constant("DB_TABLE_RESOURCE_CREATOR") . " (
    creatorID INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(255) UNIQUE,
	PRIMARY KEY (creatorID),
	FOREIGN KEY (username) REFERENCES " . constant("DB_TABLE_USER") . "(username) ON DELETE CASCADE ON UPDATE CASCADE
)");

define("RESOURCE_TABLE_CREATE_QUERY", "CREATE TABLE " . constant("DB_TABLE_RESOURCE") . " (
    resourceID INT NOT NULL AUTO_INCREMENT,
	title VARCHAR(255),
    description TEXT(1000),
	link VARCHAR(255),
	imgName VARCHAR(255),
	duration INT,
	date DATETIME DEFAULT CURRENT_TIMESTAMP,
	creatorID INT,
	PRIMARY KEY (resourceID),
	FOREIGN KEY (creatorID) REFERENCES " . constant("DB_TABLE_RESOURCE_CREATOR") . "(creatorID) ON DELETE CASCADE ON UPDATE CASCADE
)");

define("COMMENT_TABLE_CREATE_QUERY", "CREATE TABLE " . constant("DB_TABLE_COMMENT") . " (
    commentID INT NOT NULL AUTO_INCREMENT,
    commentText TEXT(1000),
	date DATETIME DEFAULT CURRENT_TIMESTAMP,
	username VARCHAR(255),
	resourceID INT,
	PRIMARY KEY (commentID),
	FOREIGN KEY (resourceID) REFERENCES " . constant("DB_TABLE_RESOURCE") . "(resourceID) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (username) REFERENCES " . constant("DB_TABLE_USER") . "(username) ON DELETE CASCADE ON UPDATE CASCADE
)");

define("LIKE_TABLE_CREATE_QUERY", "CREATE TABLE " . constant("DB_TABLE_LIKE") . " (
    likeID INT NOT NULL AUTO_INCREMENT,
	date DATETIME DEFAULT CURRENT_TIMESTAMP,
	commentID INT,
	username VARCHAR(255),
	PRIMARY KEY (likeID),
	FOREIGN KEY (commentID) REFERENCES " . constant("DB_TABLE_COMMENT") . "(commentID) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (username) REFERENCES " . constant("DB_TABLE_USER") . "(username) ON DELETE CASCADE ON UPDATE CASCADE
)");

define("REPORT_TABLE_CREATE_QUERY", "CREATE TABLE " . constant("DB_TABLE_REPORT") . " (
    reportID INT NOT NULL AUTO_INCREMENT,
	sentDate DATETIME DEFAULT CURRENT_TIMESTAMP,
	checkoutDate DATETIME DEFAULT CURRENT_TIMESTAMP,
	type ENUM( '" . constant("DB_REPORT_TYPE1") . "' , '" . constant("DB_REPORT_TYPE1") . "' ),
	status ENUM( '" . constant("DB_REPORT_CHECKED") . "' , '" . constant("DB_REPORT_TYPE1") . "'),
	resourceID INT,
	username VARCHAR(255),
	checker VARCHAR(255),
	PRIMARY KEY (reportID),
	FOREIGN KEY (resourceID) REFERENCES " . constant("DB_TABLE_RESOURCE") . "(resourceID) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (username) REFERENCES " . constant("DB_TABLE_USER") . "(username) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (checker) REFERENCES " . constant("DB_TABLE_USER") . "(username) ON DELETE CASCADE ON UPDATE CASCADE
)");

define("RATE_TABLE_CREATE_QUERY", "CREATE TABLE " . constant("DB_TABLE_RATE") . " (
    rateID INT NOT NULL AUTO_INCREMENT,
	date DATETIME DEFAULT CURRENT_TIMESTAMP,
	rateLevel ENUM('5star', '4star', '3star', '2star', '1star', '0star'),
	resourceID INT,
	username VARCHAR(255),
	PRIMARY KEY (rateID),
	FOREIGN KEY (resourceID) REFERENCES " . constant("DB_TABLE_RESOURCE") . "(resourceID) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (username) REFERENCES " . constant("DB_TABLE_USER") . "(username) ON DELETE CASCADE ON UPDATE CASCADE
)");

define("FIELD_TABLE_CREATE_QUERY", "CREATE TABLE " . constant("DB_TABLE_FIELD") . " (
    fieldID INT NOT NULL AUTO_INCREMENT,
	date DATETIME DEFAULT CURRENT_TIMESTAMP,
	title VARCHAR(255),
	imgName VARCHAR(255),
	PRIMARY KEY (fieldID)
)");

define("TOPIC_TABLE_CREATE_QUERY", "CREATE TABLE " . constant("DB_TABLE_TOPIC") . " (
    topicID INT NOT NULL AUTO_INCREMENT,
	date DATETIME DEFAULT CURRENT_TIMESTAMP,
	fieldID INT,
	title VARCHAR(255),
	imgName VARCHAR(255),
	PRIMARY KEY (topicID),
	FOREIGN KEY (fieldID) REFERENCES " . constant("DB_TABLE_FIELD") . "(fieldID) ON DELETE CASCADE ON UPDATE CASCADE
)");

define("BOOKMARK_TABLE_CREATE_QUERY", "CREATE TABLE " . constant("DB_TABLE_BOOKMARK") . " (
    bookmarkID INT NOT NULL AUTO_INCREMENT,
	resourceID INT,
	username VARCHAR(255),
	PRIMARY KEY (bookmarkID),
	FOREIGN KEY (username) REFERENCES " . constant("DB_TABLE_USER") . "(username) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (resourceID) REFERENCES " . constant("DB_TABLE_RESOURCE") . "(resourceID) ON DELETE CASCADE ON UPDATE CASCADE
)");

define("SUGGEST_TOPIC_TABLE_CREATE_QUERY", "CREATE TABLE " . constant("DB_TABLE_SUGGEST_TOPIC") . " (
    suggestID INT NOT NULL AUTO_INCREMENT,
	date DATETIME DEFAULT CURRENT_TIMESTAMP,
	adminID INT,
	ccID INT,
	topic VARCHAR(255),
	field VARCHAR(255),
	status ENUM('checked', 'unchecked'),
	description TEXT(1000),
	PRIMARY KEY (suggestID),
	FOREIGN KEY (adminID) REFERENCES " . constant("DB_TABLE_ADMIN") . "(adminID) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (ccID) REFERENCES " . constant("DB_TABLE_CC") . "(ccID) ON DELETE CASCADE ON UPDATE CASCADE
)");

define("SUGGEST_RESOURCE_TABLE_CREATE_QUERY", "CREATE TABLE " . constant("DB_TABLE_SUGGEST_RESOURCE") . " (
    suggestID INT NOT NULL AUTO_INCREMENT,
	date DATETIME DEFAULT CURRENT_TIMESTAMP,
	studentID INT,
	ccID INT,
	link VARCHAR(255),
	description TEXT(1000),
	PRIMARY KEY (suggestID),
	FOREIGN KEY (studentID) REFERENCES " . constant("DB_TABLE_STUDENT") . "(studentID) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (ccID) REFERENCES " . constant("DB_TABLE_CC") . "(ccID) ON DELETE CASCADE ON UPDATE CASCADE
)");

define("TOPIC_RESOURCE_TABLE_CREATE_QUERY", "CREATE TABLE " . constant("DB_TABLE_TOPIC_RESOURCE") . " (
    trID INT NOT NULL AUTO_INCREMENT,
	topicID INT,
	resourceID INT,
	PRIMARY KEY (trID),
	FOREIGN KEY (topicID) REFERENCES " . constant("DB_TABLE_TOPIC") . "(topicID) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (resourceID) REFERENCES " . constant("DB_TABLE_RESOURCE") . "(resourceID) ON DELETE CASCADE ON UPDATE CASCADE
)");

define("STATUS_CREATE_QUERY", "CREATE TABLE `" . constant("DB_TABLE_STATUS") . "` (
	`session` char(100) NOT NULL default '',
	`time` int(11) NOT NULL default '0'
	);");

define("EXAMPLE_TABLE_CREATE_QUERY", "CREATE TABLE " . constant("DB_TABLE_EXAMPLE") . " (
    exampleID INT NOT NULL AUTO_INCREMENT,
	title VARCHAR(255),
	link VARCHAR(255),
	resourceID INT,
	PRIMARY KEY (exampleID),
	FOREIGN KEY (resourceID) REFERENCES " . constant("DB_TABLE_RESOURCE") . "(resourceID) ON DELETE CASCADE ON UPDATE CASCADE
)");

define("TAG_TABLE_CREATE_QUERY", "CREATE TABLE " . constant("DB_TABLE_TAG") . " (
	tagID int(11) NOT NULL AUTO_INCREMENT,
	date datetime NOT NULL DEFAULT current_timestamp(),
	title varchar(200) NOT NULL,
	PRIMARY KEY (tagID)
  )");

define("RESOURCE_TAG_CREATE_QUERY", "CREATE TABLE " . constant("DB_TABLE_RESOURCE_TAG") . " (
	rtID int(11) NOT NULL AUTO_INCREMENT,
	tagID int(11) NOT NULL,
	resourceID int(11) NOT NULL,
	PRIMARY KEY (trID),
	FOREIGN KEY (tagID) REFERENCES " . constant("DB_TABLE_TAG") . "(tagID) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (resourceID) REFERENCES " . constant("DB_TABLE_RESOURCE") . "(resourceID) ON DELETE CASCADE ON UPDATE CASCADE
  )");
