DROP DATABASE IF EXISTS eComDB;
CREATE DATABASE eComDB;
USE eComDB;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";


CREATE TABLE `Users` (
  `user_id` INT PRIMARY KEY,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `account_type` ENUM ('Seller', 'Customer', 'System Admin') NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `status` VARCHAR(50) NOT NULL,
  `registered_date` DATETIME DEFAULT (NOW())
);

CREATE TABLE `Sellers` (
  `seller_id` INT PRIMARY KEY,
  `user_id` INT,
  `seller_type` ENUM ('Individual Seller', 'Business Seller') NOT NULL,
  `seller_name` VARCHAR(255),
  `description` TEXT,
  `profile_image` VARCHAR(255),
  `payment_QR` VARCHAR(255),
  `pick_up_address` TEXT
);

CREATE TABLE `Customers` (
  `customer_id` INT PRIMARY KEY,
  `user_id` INT,
  `nickname` VARCHAR(15),
  `gender` VARCHAR(10),
  `date_of_birth` DATE,
  `first_name` VARCHAR(255),
  `last_name` VARCHAR(255),
  `image_path` VARCHAR(255),
  `address` TEXT,
  `mobile` VARCHAR(20)
);

CREATE TABLE `Categories` (
  `category_id` INT PRIMARY KEY,
  `category_name` VARCHAR(255) NOT NULL,
  `status` VARCHAR(50) NOT NULL
);

CREATE TABLE `Items` (
  `item_id` INT PRIMARY KEY,
  `seller_id` INT,
  `item_name` VARCHAR(255) NOT NULL,
  `category_id` INT,
  `price` DECIMAL(10,2) NOT NULL,
  `description` TEXT,
  `item_image_path` VARCHAR(255) NOT NULL
);

CREATE TABLE `ItemRatings` (
  `rating_id` INT PRIMARY KEY,
  `customer_id` INT,
  `item_id` INT,
  `rating_value` INT NOT NULL,
  `review_text` TEXT
);

CREATE TABLE `SellerRatings` (
  `rating_id` INT PRIMARY KEY,
  `customer_id` INT,
  `seller_id` INT,
  `rating_value` INT NOT NULL,
  `review_text` TEXT
);

CREATE TABLE `OrderHistory` (
  `order_id` INT PRIMARY KEY,
  `customer_id` INT,
  `cart_id` INT,
  `order_date` DATETIME DEFAULT (NOW())
);

CREATE TABLE `ShoppingCarts` (
  `cart_id` INT PRIMARY KEY,
  `customer_id` INT,
  `total_price` DECIMAL(10, 2) NOT NULL,
  `delivery_address` TEXT NOT NULL,
  `status` VARCHAR(50) NOT NULL
);

CREATE TABLE `CartItems` (
  `cart_item_id` INT PRIMARY KEY,
  `cart_id` INT,
  `item_id` INT,
  `quantity` INT NOT NULL
);

CREATE TABLE `IndividualSellers` (
  `seller_id` INT UNIQUE PRIMARY KEY,
  `full_name` VARCHAR(255),
  `date_of_birth` DATE,
  `phone` VARCHAR(20),
  `address` TEXT,
  `passport` VARCHAR(255)
);

CREATE TABLE `BusinessSellers` (
  `seller_id` INT UNIQUE PRIMARY KEY,
  `business_name` VARCHAR(255),
  `uen` VARCHAR(20),
  `address` TEXT,
  `ACRA_filepath` VARCHAR(255)
);

ALTER TABLE `Sellers` ADD FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`);

ALTER TABLE `Customers` ADD FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`);

ALTER TABLE `Items` ADD FOREIGN KEY (`seller_id`) REFERENCES `Sellers` (`seller_id`);

ALTER TABLE `Items` ADD FOREIGN KEY (`category_id`) REFERENCES `Categories` (`category_id`);

ALTER TABLE `ItemRatings` ADD FOREIGN KEY (`customer_id`) REFERENCES `Customers` (`customer_id`);

ALTER TABLE `ItemRatings` ADD FOREIGN KEY (`item_id`) REFERENCES `Items` (`item_id`);

ALTER TABLE `SellerRatings` ADD FOREIGN KEY (`customer_id`) REFERENCES `Customers` (`customer_id`);

ALTER TABLE `SellerRatings` ADD FOREIGN KEY (`seller_id`) REFERENCES `Sellers` (`seller_id`);

ALTER TABLE `OrderHistory` ADD FOREIGN KEY (`customer_id`) REFERENCES `Customers` (`customer_id`);

ALTER TABLE `OrderHistory` ADD FOREIGN KEY (`cart_id`) REFERENCES `ShoppingCarts` (`cart_id`);

ALTER TABLE `ShoppingCarts` ADD FOREIGN KEY (`customer_id`) REFERENCES `Customers` (`customer_id`);

ALTER TABLE `CartItems` ADD FOREIGN KEY (`cart_id`) REFERENCES `ShoppingCarts` (`cart_id`);

ALTER TABLE `CartItems` ADD FOREIGN KEY (`item_id`) REFERENCES `Items` (`item_id`);

ALTER TABLE `IndividualSellers` ADD FOREIGN KEY (`seller_id`) REFERENCES `Sellers` (`seller_id`);

ALTER TABLE `BusinessSellers` ADD FOREIGN KEY (`seller_id`) REFERENCES `Sellers` (`seller_id`);
