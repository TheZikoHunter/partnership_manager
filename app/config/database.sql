CREATE DATABASE province_part;
USE province_part;
ALTER DATABASE province_part CHARACTER SET cp1256 COLLATE cp1256_general_ci;
CREATE TABLE Association(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(255) NOT NULL,
    responsable VARCHAR(255) DEFAULT '??? ?????',
    city VARCHAR(100) DEFAULT '??? ??????',
    adresse LONGTEXT,
    tel VARCHAR(20),
    fax VARCHAR(20),
    e_mail VARCHAR(100),
    site VARCHAR(255)
);
CREATE TABLE Institution(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(255) NOT NULL,
    responsable VARCHAR(255) DEFAULT '??? ?????',
    city VARCHAR(100) DEFAULT '??? ??????',
    adresse LONGTEXT,
    tel VARCHAR(20),
    fax VARCHAR(20),
    e_mail VARCHAR(100),
    site VARCHAR(255)
);

CREATE TABLE Scale(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(50) NOT NULL
);
CREATE TABLE Partnership(
    signing_date DATE DEFAULT(CURRENT_TIMESTAMP),
    period TINYINT,
    active TINYINT(1) NOT NULL,
    renewable TINYINT (1) NOT NULL DEFAULT(1),
    scale_id INT NOT NULL REFERENCES Scale(id) ON DELETE CASCADE ON UPDATE CASCADE,
    subject LONGTEXT,
    association_id INT NOT NULL REFERENCES Association(id) ON DELETE CASCADE ON UPDATE CASCADE,
    institution_id INT NOT NULL REFERENCES Institution(id) ON DELETE CASCADE ON UPDATE CASCADE,
    archived TINYINT(1) NOT NULL,
    cost VARCHAR(100)
);
CREATE TABLE Action(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    operation VARCHAR(255) NOT NULL,
    time DATETIME NOT NULL,
    association_id INT NOT NULL REFERENCES Partnership(association_id) ON DELETE CASCADE ON UPDATE CASCADE,
    institution_id INT NOT NULL REFERENCES Partnership(institution_id) ON DELETE CASCADE ON UPDATE CASCADE,
    signing_date DATE NOT NULL REFERENCES Partnership(signing_date) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE User (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    admin TINYINT(1)
);
INSERT INTO Scale (name) VALUES('ãÍáí');
INSERT INTO Scale (name) VALUES('ÇÞáíãí');
INSERT INTO Scale (name) VALUES('Ìåæí');
INSERT INTO Scale (name) VALUES('æØäí');
INSERT INTO Scale (name) VALUES('Ïæáí');