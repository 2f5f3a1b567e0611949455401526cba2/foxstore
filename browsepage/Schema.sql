CREATE SCHEMA Foxdb;
CREATE TABLE Foxdb.Products(
	ProductID INT PRIMARY KEY, 
	Name VARCHAR(32) NOT NULL,
	Description TINYTEXT,
	Price decimal(9,2) NOT NULL,
	Stock INT UNSIGNED DEFAULT 0
)
CREATE TABLE Foxdb.Orders(
	OrderID INT PRIMARY KEY AUTO_INCREMENT,
	Status ENUM('Unpaid','Paid','Packaged','Delivered')
	Time DATE,
	CustomerID INT,
	foreign key (CustomerID) REFERENCES Customers(CustomerID)
)
CREATE TABLE Foxdb.OrderItems(
	OrderItemID (OrderID,Idx) PRIMARY KEY,
	ORDERID INT,
	Idx int,
	ProductID INT,
	FOREIGN KEY (OrderID) REFERENCES Orders(OrderId)
	FOREIGN KEY (ProductID) REFERENCES 	Products(ProductID)
)
CREATE TABLE Foxdb.Images(
	ImageID INT PRIMARY KEY,
	--ProductID, This is a test
	Idx INT UNSIGNED,
	ImagePath TINYTEXT,
	FOREIGN KEY ProductID REFERENCES Products(ProductID)
	FOREIGN KEY Idx REFERENCES OrderItems(Idx)

)
CREATE TABLE Foxdb.Customers(
	CustomerID INT PRIMARY KEY,
	Name TINYTEXT NOT NULL,
	Address TINYTEXT NOT NULL
)
CREATE TABLE Admins(
	AdminID INT PRIMARY KEY,
	Username TINYTEXT NOT NULL,
	Password TINYTEXT NOT NULL
)