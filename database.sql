CREATE DATABASE transfree;
use transfree;

CREATE TABLE users (
  id int AUTO_INCREMENT PRIMARY KEY,
  username varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  email varchar(255)  NOT NULL,
  role ENUM("gebruiker", "admin"),
  created_at datetime default CURRENT_TIMESTAMP
);

CREATE TABLE uploads (
  id int AUTO_INCREMENT PRIMARY KEY,
  user_id int NOT NULL,
  title varchar(255) NOT NULL,
  description TEXT,
  filename varchar(255),
  file_hash varchar(64) NOT NULL,
  token varchar(255),
  created_at datetime default CURRENT_TIMESTAMP,

  CONSTRAINT fk_upload_user
  FOREIGN KEY (user_id)
  REFERENCES users(id)
);

CREATE TABLE downloads (
  id int AUTO_INCREMENT PRIMARY KEY,
  upload_id int NOT NULL,
  ip_address varchar(255),
  browser varchar(30),
  created_at datetime default CURRENT_TIMESTAMP,

  CONSTRAINT fk_download_upload
  FOREIGN KEY (upload_id)
  REFERENCES uploads(id)
);

 CREATE TABLE logs (
  id int AUTO_INCREMENT PRIMARY KEY,
  type enum("info", "warning", "error", "debug"),
  content text,
  user_id int NOT NULL,
  ip_address varchar(255),
  browser varchar(30),
  created_at datetime default CURRENT_TIMESTAMP,

  CONSTRAINT fk_user_logs
  FOREIGN KEY (user_id)
  REFERENCES users(id)
 );

