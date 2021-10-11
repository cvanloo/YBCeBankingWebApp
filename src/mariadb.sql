-- drop and recreate database

DROP DATABASE IF EXISTS YBCBanking;
CREATE DATABASE YBCBanking;
USE YBCBanking;

-- entities

CREATE TABLE users (
	id int PRIMARY KEY AUTO_INCREMENT,
	email varchar(255) NOT NULL,
	username varchar(255) NOT NULL,
	passwdhash varchar(255) NOT NULL,
	accountbalance float NOT NULL DEFAULT 0,
	created DATE NOT NULL DEFAULT CURDATE(),
	deleted tinyint(1) NOT NULL DEFAULT 0,

	UNIQUE(email),
	UNIQUE(username)
);

CREATE TABLE transactions (
	id int PRIMARY KEY AUTO_INCREMENT,
	amount float NOT NULL,
	created DATETIME NOT NULL DEFAULT CURDATE(),
	title varchar(255) NOT NULL,
	description varchar(512),
	obligee_id int NOT NULL,
	debtor_id int NOT NULL,
	-- status ENUM('pending', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
	status int NOT NULL DEFAULT 0,

	FOREIGN KEY (obligee_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (debtor_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE
);
