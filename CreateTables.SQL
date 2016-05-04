CREATE TABLE Projects (
	pid INT NOT NULL AUTO_INCREMENT,
	cid INT,
	title VARCHAR(100),
	status INT,
	startDate VARCHAR(20),
	endDate VARCHAR(20),
	buildingName VARCHAR(100),
	address VARCHAR(100),
	zip int,
	type int,
	summary VARCHAR(2500),
	link VARCHAR(200),
	pic VARCHAR(200),
	contactName VARCHAR(100),
	contactEmail VARCHAR(100),
	contactPhone VARCHAR(16),
	lat REAL,
	lng REAL,
	PRIMARY KEY(pid)
);

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
	zip int,
	type int,
	summary VARCHAR(2500),
	link VARCHAR(200),
	pic VARCHAR(200),
	contactName VARCHAR(100),
	contactEmail VARCHAR(100),
	contactPhone VARCHAR(16),
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