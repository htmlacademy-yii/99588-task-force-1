CREATE DATABASE taskforce CHARACTER SET utf8 COLLATE utf8_general_ci;

USE taskforce;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email CHAR(64),
    name CHAR(64),
    password CHAR(256),
    dt_add DATETIME,
    rate TINYINT,
    tasks_done INT,
    tasks_failed INT,
    city_id INT,
    profiles_id INT
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dt_add DATETIME,
    category_id INT,
    description CHAR(256),
    expire DATE,
    name CHAR(64),
    address CHAR(128),
    budget INT,
    lat DOUBLE,
    long DOUBLE,
    status  CHAR(64),
    employer_id INT,
    executor_id INT,
    city_id INT
);

CREATE TABLE replies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dt_add DATETIME,
    rate TINYINT,
    description CHAR(256),
    budget INT,
    user_id INT,
    task_id INT
);

CREATE TABLE profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    address CHAR(128),
    bd DATE,
    about CHAR(256),
    phone CHAR(64),
    skype CHAR(64)
);

CREATE TABLE opinions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dt_add DATETIME,
    rate TINYINT,
    description CHAR(256),
    user_id INT,
    task_id INT
);

CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    city CHAR(64),
    lat DOUBLE,
    long DOUBLE
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(64),
    icon CHAR(64)
);

CREATE TABLE files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(128),
    user_id INT,
    task_id INT
);

CREATE TABLE available_notification_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    notification_type CHAR(64)
);

CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    text CHAR(256),
    notification_type CHAR(64)
);

CREATE TABLE dialogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    text CHAR(256),
    sender_id INT,
    recipient_id INT
);
