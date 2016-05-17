CREATE TABLE Projects (
	pid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	cid INT UNSIGNED,
	title VARCHAR(100),
	status INT,
	startDate VARCHAR(20),
	endDate VARCHAR(20),
	buildingName VARCHAR(100),
	address VARCHAR(100),
	zip VARCHAR(6),
	type int,
	summary TEXT,
	link VARCHAR(200),
	pic VARCHAR(200),
	conid INT UNSIGNED,
	fundedBy VARCHAR(100),
	keywords VARCHAR(100),
	stemmedSearchText TEXT,
	visible BOOLEAN,
	lat REAL,
	lng REAL,
	FULLTEXT(stemmedSearchText)
) ENGINE=MyISAM;

CREATE TABLE History (
	hid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	time TIMESTAMP,
	deleted BOOLEAN,
	pid INT UNSIGNED,
	cid INT UNSIGNED,
	title VARCHAR(100),
	status INT,
	startDate VARCHAR(20),
	endDate VARCHAR(20),
	buildingName VARCHAR(100),
	address VARCHAR(100),
	zip VARCHAR(6),
	type int,
	summary TEXT,
	link VARCHAR(200),
	pic VARCHAR(200),
	conid INT UNSIGNED,
	fundedBy VARCHAR(100),
	keyWords VARCHAR(100),
	stemmedSearchText TEXT,
	visible BOOLEAN,
	lat REAL,
	lng REAL
);

CREATE TABLE Centers (
	cid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100),
	acronym VARCHAR(8),
	color CHAR(7)
);

CREATE TABLE Contacts (
	conid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100),
	email VARCHAR(100),
	phone VARCHAR(16)
);

CREATE TABLE Users (
	uid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(64),
	name VARCHAR(100),
	password VARCHAR(64),
	root BOOLEAN
);