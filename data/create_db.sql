CREATE DATABASE flexap CHARACTER SET utf8;
CREATE USER 'flexap'@'localhost' IDENTIFIED BY 'flexap';
GRANT ALL PRIVILEGES ON flexap.* TO 'flexap'@'localhost';
