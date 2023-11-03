IF OBJECT_ID('Users', 'U') IS NOT NULL
    DROP TABLE Users;

IF OBJECT_ID('Sellers', 'U') IS NOT NULL
    DROP TABLE Sellers;

IF OBJECT_ID('Customers', 'U') IS NOT NULL
    DROP TABLE Customers;

IF OBJECT_ID('Categories', 'U') IS NOT NULL
    DROP TABLE Categories;

IF OBJECT_ID('Items', 'U') IS NOT NULL
    DROP TABLE Items;

IF OBJECT_ID('ItemRatings', 'U') IS NOT NULL
    DROP TABLE ItemRatings;

IF OBJECT_ID('SellerRatings', 'U') IS NOT NULL
    DROP TABLE SellerRatings;

IF OBJECT_ID('OrderHistory', 'U') IS NOT NULL
    DROP TABLE OrderHistory;

IF OBJECT_ID('ShoppingCarts', 'U') IS NOT NULL
    DROP TABLE ShoppingCarts;

IF OBJECT_ID('CartItems', 'U') IS NOT NULL
    DROP TABLE CartItems;

IF OBJECT_ID('IndividualSellers', 'U') IS NOT NULL
    DROP TABLE IndividualSellers;

IF OBJECT_ID('BusinessSellers', 'U') IS NOT NULL
    DROP TABLE BusinessSellers;


-- Create the Users table
CREATE TABLE [Users] (
  [user_id] INT PRIMARY KEY IDENTITY(1, 1),
  [username] VARCHAR(255) NOT NULL,
  [password] VARCHAR(255) NOT NULL,
  [account_type] NVARCHAR(255) CHECK ([account_type] IN ('Seller', 'Customer', 'System Admin')) NOT NULL,
  [email] VARCHAR(255) NOT NULL,
  [status] VARCHAR(50) NOT NULL,
  [otp] VARCHAR(6) DEFAULT (NULL),
  [otp_expiration] DATETIME DEFAULT (NULL),
  [registered_date] DATETIME DEFAULT (GETDATE())
)
GO

CREATE TABLE [Sellers] (
  [seller_id] INT PRIMARY KEY IDENTITY(1, 1),
  [user_id] INT,
  [seller_type] nvarchar(255) CHECK ([seller_type] IN ('Individual Seller', 'Business Seller')) NOT NULL,
  [seller_name] VARCHAR(255),
  [description] TEXT,
  [profile_image] VARCHAR(255),
  [payment_QR] VARCHAR(255),
  [pick_up_address] TEXT
)
GO

CREATE TABLE [Customers] (
  [customer_id] INT PRIMARY KEY IDENTITY(1, 1),
  [user_id] INT,
  [nickname] VARCHAR(15),
  [gender] VARCHAR(10),
  [date_of_birth] DATE,
  [first_name] VARCHAR(255),
  [last_name] VARCHAR(255),
  [image_path] VARCHAR(255),
  [address] TEXT,
  [mobile] VARCHAR(20)
)
GO

CREATE TABLE [Categories] (
  [category_id] INT PRIMARY KEY IDENTITY(1, 1),
  [category_name] VARCHAR(255) NOT NULL,
  [status] VARCHAR(50) NOT NULL
)
GO

CREATE TABLE [Items] (
  [item_id] INT PRIMARY KEY IDENTITY(1, 1),
  [seller_id] INT,
  [item_name] VARCHAR(255) NOT NULL,
  [category_id] INT,
  [price] DECIMAL(10,2) NOT NULL,
  [description] TEXT,
  [quantity] INT NOT NULL,
  [item_image_path] VARCHAR(255) NOT NULL
)
GO

CREATE TABLE [ItemRatings] (
  [rating_id] INT PRIMARY KEY IDENTITY(1, 1),
  [customer_id] INT,
  [item_id] INT,
  [rating_value] INT NOT NULL,
  [review_text] TEXT
)
GO

CREATE TABLE [SellerRatings] (
  [rating_id] INT PRIMARY KEY IDENTITY(1, 1),
  [customer_id] INT,
  [seller_id] INT,
  [rating_value] INT NOT NULL,
  [review_text] TEXT
)
GO

CREATE TABLE [OrderHistory] (
  [order_id] INT PRIMARY KEY IDENTITY(1, 1),
  [customer_id] INT,
  [cart_id] INT,
  [order_date] DATETIME DEFAULT (GETDATE())
)
GO

CREATE TABLE [ShoppingCarts] (
  [cart_id] INT PRIMARY KEY IDENTITY(1, 1),
  [customer_id] INT,
  [total_price] DECIMAL(10, 2) NOT NULL,
  [delivery_address] TEXT NOT NULL,
  [status] VARCHAR(50) NOT NULL
)
GO

CREATE TABLE [CartItems] (
  [cart_item_id] INT PRIMARY KEY IDENTITY(1, 1),
  [cart_id] INT,
  [item_id] INT,
  [quantity] INT NOT NULL
)
GO

CREATE TABLE [IndividualSellers] (
  [seller_id] INT PRIMARY KEY IDENTITY(1, 1),
  [full_name] VARCHAR(255),
  [date_of_birth] DATE,
  [phone] VARCHAR(20),
  [address] TEXT,
  [passport] VARCHAR(255)
)
GO

CREATE TABLE [BusinessSellers] (
  [seller_id] INT PRIMARY KEY IDENTITY(1, 1),
  [business_name] VARCHAR(255),
  [uen] VARCHAR(20),
  [address] TEXT,
  [ACRA_filepath] VARCHAR(255)
)
GO

ALTER TABLE [Sellers] ADD FOREIGN KEY ([user_id]) REFERENCES [Users] ([user_id])
GO

ALTER TABLE [Customers] ADD FOREIGN KEY ([user_id]) REFERENCES [Users] ([user_id])
GO

ALTER TABLE [Items] ADD FOREIGN KEY ([seller_id]) REFERENCES [Sellers] ([seller_id])
GO

ALTER TABLE [Items] ADD FOREIGN KEY ([category_id]) REFERENCES [Categories] ([category_id])
GO

ALTER TABLE [ItemRatings] ADD FOREIGN KEY ([customer_id]) REFERENCES [Customers] ([customer_id])
GO

ALTER TABLE [ItemRatings] ADD FOREIGN KEY ([item_id]) REFERENCES [Items] ([item_id])
GO

ALTER TABLE [SellerRatings] ADD FOREIGN KEY ([customer_id]) REFERENCES [Customers] ([customer_id])
GO

ALTER TABLE [SellerRatings] ADD FOREIGN KEY ([seller_id]) REFERENCES [Sellers] ([seller_id])
GO

ALTER TABLE [OrderHistory] ADD FOREIGN KEY ([customer_id]) REFERENCES [Customers] ([customer_id])
GO

ALTER TABLE [OrderHistory] ADD FOREIGN KEY ([cart_id]) REFERENCES [ShoppingCarts] ([cart_id])
GO

ALTER TABLE [ShoppingCarts] ADD FOREIGN KEY ([customer_id]) REFERENCES [Customers] ([customer_id])
GO

ALTER TABLE [CartItems] ADD FOREIGN KEY ([cart_id]) REFERENCES [ShoppingCarts] ([cart_id])
GO

ALTER TABLE [CartItems] ADD FOREIGN KEY ([item_id]) REFERENCES [Items] ([item_id])
GO

ALTER TABLE [IndividualSellers] ADD FOREIGN KEY ([seller_id]) REFERENCES [Sellers] ([seller_id])
GO

ALTER TABLE [BusinessSellers] ADD FOREIGN KEY ([seller_id]) REFERENCES [Sellers] ([seller_id])
GO


-- Inserting data into the Users table
INSERT INTO Users (username, [password], account_type, email, [status])
VALUES
-- pass123
  ('john_doe', '$2y$10$iExRjtQNHAJ2rG1bT4.PE.ZXIBGI/TQsg/AEDM8xn2SJhK5JQ93DG', 'Customer', 'kaibutsu740@gmail.com', 'Active'),
  -- passadmin123
  ('admin', '$2y$10$MxrJ1oXQvqyHI2/qHeZRIudv.w3Lr15Y0c3YKLTKg48LFazFR7UMy', 'System Admin', 'admin@example.com', 'Active');

-- Inserting data into the Customers table
INSERT INTO Customers (user_id, nickname, gender, date_of_birth, first_name, last_name, image_path, address, mobile)
VALUES
  (1, 'johndoe123', 'Male', '1990-05-15', 'John', 'Doe', 'john_doe.jpg', '789 Oak St, City', '+1234567890');
