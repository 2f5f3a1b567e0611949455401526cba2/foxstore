DROP DATABASE IF EXISTS store;
CREATE DATABASE store;

CREATE TABLE store.customers (
	customer_id BIGINT        UNSIGNED NOT NULL,
	name        TINYTEXT               NOT NULL,
	address     TINYTEXT               NOT NULL,
	Username 	TINYTEXT			   NOT NULL,
	Password 	Binary(60)			   NOT NULL,	
	PRIMARY KEY (customer_id)
);

CREATE TABLE store.products (
	product_id  BIGINT        UNSIGNED NOT NULL,
	name        VARCHAR(32)            NOT NULL,
	description TINYTEXT,
	price       DECIMAL(9,2)  UNSIGNED NOT NULL,
	stock       INT UNSIGNED  DEFAULT 0,

	PRIMARY KEY(product_id)
);

CREATE TABLE store.orders (
	order_id    BIGINT        UNSIGNED NOT NULL,
	status      ENUM("unpaid", "paid", "packaged", "delivered"),
	time        DATETIME,
	customer_id BIGINT        UNSIGNED NOT NULL,

	FOREIGN KEY (customer_id) REFERENCES customers (customer_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,

	PRIMARY KEY (order_id)
);

CREATE TABLE store.order_items (
	order_id    BIGINT        UNSIGNED NOT NULL,
	product_id  BIGINT        UNSIGNED,
	amount      INT           UNSIGNED NOT NULL,

	FOREIGN KEY (order_id)   REFERENCES orders(order_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,

	FOREIGN KEY (product_id) REFERENCES products(product_id)
		ON DELETE SET NULL
		ON UPDATE CASCADE
);

CREATE TABLE store.images (
	product_id  BIGINT        UNSIGNED NOT NULL,
	image_path  TINYTEXT               NOT NULL,
	FOREIGN KEY (product_id) REFERENCES products(product_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);


CREATE TABLE store.admins (
	admin_id    BIGINT        UNSIGNED NOT NULL,
	username    VARCHAR(20)            NOT NULL,
	password    TINYTEXT               NOT NULL,
 
	PRIMARY KEY (admin_id)
);

