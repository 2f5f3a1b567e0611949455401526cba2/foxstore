START TRANSACTION;

DROP DATABASE IF EXISTS store;
CREATE DATABASE store;

CREATE TABLE store.users(
	user_id     BIGINT        UNSIGNED AUTO_INCREMENT,

	user_type   ENUM("admin", "customer") DEFAULT("customer") NOT NULL,
 
	username    VARCHAR(20)            NOT NULL,
	password    BINARY(60)               NOT NULL,
 
	PRIMARY KEY (user_id),
	UNIQUE (username)
);

CREATE TABLE store.products (
	product_id  BIGINT        UNSIGNED AUTO_INCREMENT,
	name        VARCHAR(32)            NOT NULL,
	description VARCHAR(512),
	price       DECIMAL(9,2)  UNSIGNED NOT NULL,
	stock       INT UNSIGNED  DEFAULT 0,

	PRIMARY KEY(product_id)
);

CREATE TABLE store.orders (
	order_id    BIGINT        UNSIGNED AUTO_INCREMENT,

	name        TINYTEXT               NOT NULL,
	address     TINYTEXT               NOT NULL,

	status      ENUM("unpaid", "paid", "packaged", "delivered"),

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
	price       DECIMAL(9,2)  UNSIGNED NOT NULL,

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


CREATE TABLE store.cart (
	-- id          BIGINT        UNSIGNED AUTO_INCREMENT,
	user_id     BIGINT        UNSIGNED NOT NULL,
	product_id  BIGINT        UNSIGNED,
	amount      INT           UNSIGNED NOT NULL,

	FOREIGN KEY (user_id)    REFERENCES users(user_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,

	FOREIGN KEY (product_id) REFERENCES products(product_id)
		ON UPDATE CASCADE,

	PRIMARY KEY (user_id, product_id)
);

CREATE TABLE store.comments (
	id            BIGINT    UNSIGNED AUTO_INCREMENT,
	product_id    BIGINT    UNSIGNED NOT NULL,
	user_id       BIGINT    UNSIGNED NOT NULL,
	rating        TINYINT   UNSIGNED,
	comment_title VARCHAR(32) NOT NULL,
	comment_desc  VARCHAR(512),
	time          DATETIME  NOT NULL DEFAULT(CURRENT_TIMESTAMP()),

	FOREIGN KEY (product_id) REFERENCES products(product_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,

	FOREIGN KEY (user_id)    REFERENCES users(user_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
        
	primary key(id)
);

CREATE VIEW product_summary AS
SELECT 
	p.product_id,
	p.name,
	p.price,
	p.stock,
	AVG(c.rating) AS rating,
	(SELECT image_path FROM images i 
		WHERE i.product_id = p.product_id 
		LIMIT 1) AS thumb,
  (SELECT image_alt FROM images i 
		WHERE i.product_id = p.product_id 
		LIMIT 1) AS alt
FROM products p
LEFT JOIN comments c ON p.product_id = c.product_id
GROUP BY p.product_id;

COMMIT;
