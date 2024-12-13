CREATE DATABASE coffee_shop;
CREATE TABLE drinks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,  
    price DECIMAL(10, 2) NOT NULL 
);CREATE TABLE add_ons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,  
    price DECIMAL(10, 2) NOT NULL,  
    is_free BOOLEAN DEFAULT 0 
);CREATE TABLE orders (
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
);
