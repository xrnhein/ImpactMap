CREATE TABLE Projects (
	pid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	cid INT,
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
	contactName VARCHAR(100),
	contactEmail VARCHAR(100),
	contactPhone VARCHAR(16),
	fundedBy VARCHAR(100),
	keywords VARCHAR(100),
	stemmedSearchText TEXT,
	lat REAL,
	lng REAL,
	FULLTEXT(stemmedSearchText)
) ENGINE=MyISAM;

CREATE TABLE History (
	hid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	time TIMESTAMP,
	pid INT,
	cid INT,
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
	contactName VARCHAR(100),
	contactEmail VARCHAR(100),
	contactPhone VARCHAR(16),
	fundedBy VARCHAR(100),
	keyWords VARCHAR(100),
	stemmedSearchText TEXT,
	deleted BOOLEAN,
	lat REAL,
	lng REAL
);

CREATE TABLE Centers (
	cid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100),
	acronym VARCHAR(8),
	color CHAR(7)
);

CREATE TABLE Users (
	uid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(64),
	password VARCHAR(64),
	root BOOLEAN,
	admin BOOLEAN,
	cas BOOLEAN
);