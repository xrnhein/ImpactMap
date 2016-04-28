CREATE TABLE Display (
	pid INT NOT NULL,
	address VARCHAR(100),
	description VARCHAR(1000),
	pic VARCHAR(100),
	link VARCHAR(100),
	lat REAL,
	lng REAL,
	anim VARCHAR(100),
	title VARCHAR(100),
	infoopen INT,
	category VARCHAR(100),
	approved INT,
	retina INT,
	PRIMARY KEY(pid)
);

CREATE TABLE History (
	eid INT NOT NULL,
	pid INT NOT NULL,
	time TIMESTAMP,
	address VARCHAR(100),
	description VARCHAR(1000),
	pic VARCHAR(100),
	link VARCHAR(100),
	lat REAL,
	lng REAL,
	anim VARCHAR(100),
	title VARCHAR(100),
	infoopen INT,
	category VARCHAR(100),
	approved INT,
	retina INT,
	PRIMARY KEY(eid)
);