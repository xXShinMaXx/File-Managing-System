-- ===========================================================
--  FileSphere - Local Database Schema
--  Import this file in phpMyAdmin (Import tab) or run it in
--  the MySQL command line to create the database and tables
--  this app expects.
-- ===========================================================

CREATE DATABASE IF NOT EXISTS filesphere_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE filesphere_db;

-- -----------------------------------------------------------
-- Table: user
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS user (
    ID       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email    VARCHAR(150) NOT NULL,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- -----------------------------------------------------------
-- Table: files
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS files (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    filename    VARCHAR(255) NOT NULL,
    owner       VARCHAR(100) NOT NULL,
    filesize    INT NOT NULL,
    filetype    VARCHAR(20) NOT NULL,
    archived    TINYINT(1) NOT NULL DEFAULT 0,
    deleted     TINYINT(1) NOT NULL DEFAULT 0,
    upload_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX (owner),
    CONSTRAINT fk_files_owner FOREIGN KEY (owner) REFERENCES user(username)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- -----------------------------------------------------------
-- Table: shared_files
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS shared_files (
    ID          INT AUTO_INCREMENT PRIMARY KEY,
    file_id     INT NOT NULL,
    owner       VARCHAR(100) NOT NULL,
    shared_with VARCHAR(100) NOT NULL,
    shared_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX (file_id),
    INDEX (shared_with),
    CONSTRAINT fk_shared_file FOREIGN KEY (file_id) REFERENCES files(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_shared_owner FOREIGN KEY (owner) REFERENCES user(username)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_shared_with FOREIGN KEY (shared_with) REFERENCES user(username)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;
