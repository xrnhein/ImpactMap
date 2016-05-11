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
	lat REAL,
	lng REAL,
	FULLTEXT(title, buildingName, address, zip, keywords, contactName)
) ENGINE=MyISAM;

CREATE TABLE History (
	hid INT NOT NULL AUTO_INCREMENT,
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
	deleted BOOLEAN,
	lat REAL,
	lng REAL,
	PRIMARY KEY(hid)
);

CREATE TABLE Centers (
	cid INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(100),
	acronym VARCHAR(8),
	color CHAR(7),
	PRIMARY KEY(cid)
);

CREATE TABLE Users (
	uid INT NOT NULL AUTO_INCREMENT,
	email VARCHAR(64),
	password VARCHAR(64),
	root BOOLEAN,
	admin BOOLEAN,
	cas BOOLEAN,
	PRIMARY KEY(uid)
);