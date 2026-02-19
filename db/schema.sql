START TRANSACTION;

DROP DATABASE IF EXISTS store;
CREATE DATABASE store;

CREATE TABLE store.users(
	user_id     BIGINT        UNSIGNED AUTO_INCREMENT,

	user_type   ENUM("admin", "customer") DEFAULT("customer") NOT NULL,
 
	username    VARCHAR(20)            NOT NULL,
	password    BINARY(60)               NOT NULL,
 
	PRIMARY KEY (user_id)
);

CREATE TABLE store.products (
	product_id  BIGINT        UNSIGNED AUTO_INCREMENT,
	name        VARCHAR(32)            NOT NULL,
	description TINYTEXT,
	price       DECIMAL(9,2)  UNSIGNED NOT NULL,
	stock       INT UNSIGNED  DEFAULT 0,

	PRIMARY KEY(product_id)
);

CREATE TABLE store.orders (
	order_id    BIGINT        UNSIGNED AUTO_INCREMENT,

	name        TINYTEXT               NOT NULL,
	address     TINYTEXT               NOT NULL,

	status      ENUM("cart", "unpaid", "paid", "packaged", "delivered")
		DEFAULT("cart"),

	time        DATETIME               NOT NULL DEFAULT(CURRENT_TIMESTAMP()),
	user_id     BIGINT        UNSIGNED NOT NULL,

	FOREIGN KEY (user_id) REFERENCES users(user_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,

	PRIMARY KEY (order_id)
);

CREATE TABLE store.order_items (
	id          BIGINT        UNSIGNED AUTO_INCREMENT,
	order_id    BIGINT        UNSIGNED NOT NULL,
	product_id  BIGINT        UNSIGNED,
	amount      INT           UNSIGNED NOT NULL,

	FOREIGN KEY (order_id)   REFERENCES orders(order_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,

	FOREIGN KEY (product_id) REFERENCES products(product_id)
		ON DELETE SET NULL
		ON UPDATE CASCADE,

	PRIMARY KEY (id)
);

CREATE TABLE store.images (
	id          BIGINT        UNSIGNED AUTO_INCREMENT,
	product_id  BIGINT        UNSIGNED NOT NULL,
	image_path  TINYTEXT               NOT NULL,
	image_alt   TINYTEXT,
	image_cap   TINYTEXT,
	FOREIGN KEY (product_id) REFERENCES products(product_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,

	PRIMARY KEY (id)
);

COMMIT;
