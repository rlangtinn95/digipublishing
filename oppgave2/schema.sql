CREATE DATABASE coffee_shop;

CREATE TABLE drinks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);

CREATE TABLE add_ons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    is_free BOOLEAN DEFAULT 0
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    total_price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    drink_id INT,
    add_on_id INT,
    quantity INT DEFAULT 1,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (drink_id) REFERENCES drinks(id) ON DELETE CASCADE,
    FOREIGN KEY (add_on_id) REFERENCES add_ons(id) ON DELETE CASCADE
);


-- These need to be manually populated before entering any value into the form, or error will occur
USE coffee_shop;

INSERT INTO drinks (name, price) VALUES
('Kaffe', 30.00),  
('Dobbel', 30.00), 
('Cappuccino', 35.00), 
('Macchiato', 40.00), 
('Dobbel', 40.00), 
('Pumpkin Spice Latte', 45.00); 

INSERT INTO add_ons (name, price, is_free) VALUES
('Melk', 5.00, 0),  
('Sukker', 5.00, 0),  
('Sjokoladedryss', 5.00, 0),  
('Is', 0.00, 1),  
('Sugerør', 0.00, 1); 
