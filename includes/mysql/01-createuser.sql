CREATE USER 'mercaswapp'@'%' IDENTIFIED BY 'mercaswapp';
GRANT ALL PRIVILEGES ON `mercaswapp`.* TO 'mercaswapp'@'%';

CREATE USER 'mercaswapp'@'localhost' IDENTIFIED BY 'mercaswapp';
GRANT ALL PRIVILEGES ON `mercaswapp`.* TO 'mercaswapp'@'localhost';