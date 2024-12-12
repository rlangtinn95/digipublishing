CREATE DATABASE registration_schema;
USE registration_schema;

CREATE TABLE personal_information (
      id INT PRIMARY KEY AUTO_INCREMENT,
      first_name VARCHAR(50) NOT NULL,
      last_name VARCHAR(50) NOT NULL,
      e_mail VARCHAR(100),
      phone_number VARCHAR(10) NOT NULL,
      birth_date DATE NOT NULL
);

INSERT INTO registration_schema (first_name, last_name, email, phone_number, birth_date)
VALUES
('Richard', 'Langtinn', 'richard@hotmail.com', 90909090, 1997-04-20);