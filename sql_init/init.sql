# Ror development purpose only !
# Refer to our staff for production related question.
CREATE DATABASE IF NOT EXISTS gacom;
CREATE USER IF NOT EXISTS 'user' IDENTIFIED BY '12345678';
GRANT ALL PRIVILEGES ON gacom.* TO 'user';
