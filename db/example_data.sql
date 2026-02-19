START TRANSACTION;

INSERT INTO store.users (user_type, username, password) VALUES
-- user : "admin", pass: "elvis"
("admin", "admin", 0x243279243130243143703973494643325444484d507433593658647675707a6b784c4d5671335654766c68324359476f745a577a3258746f547a4736);

INSERT INTO store.products (name, description, price, stock) VALUES
("Example Product 1 Chairman", "Chairman, a gentelman that Shares with the people without position. The Chairman is mostly made out of Wood, please don't mind it. IKEA made them like this.\nThis is a Example Description for Example product 1 written in the example_data.sql file.", 13.37, 10),
("Example Product 2 Toothbrush", "“... TOOTHBRUSH IN THE JAW TOOTHBRUSH BRUSH BRUSH tooth jaw foam dome in the foam Roman dome come home home in the jaw Rome dome tooth toothbrush toothpick pickpocket socket rocket ...” - Aynrand the fountainhead.\nThis is a Example Description for Example product 2 written in the example_data.sql file. ", 10, 1);

-- CREATE TABLE store.orders (
-- 	order_id    BIGINT        UNSIGNED AUTO_INCREMENT,

-- 	name        TINYTEXT               NOT NULL,
-- 	address     TINYTEXT               NOT NULL,

-- 	status      ENUM("cart", "unpaid", "paid", "packaged", "delivered")
-- 		DEFAULT("cart"),

-- 	time        DATETIME               NOT NULL DEFAULT(CURRENT_TIMESTAMP()),
-- 	user_id     BIGINT        UNSIGNED NOT NULL,

-- 	FOREIGN KEY (user_id) REFERENCES users(user_id)
-- 		ON DELETE CASCADE
-- 		ON UPDATE CASCADE,

-- 	PRIMARY KEY (order_id)
-- );

-- CREATE TABLE store.order_items (
-- 	id          BIGINT        UNSIGNED AUTO_INCREMENT,
-- 	order_id    BIGINT        UNSIGNED NOT NULL,
-- 	product_id  BIGINT        UNSIGNED,
-- 	amount      INT           UNSIGNED NOT NULL,

-- 	FOREIGN KEY (order_id)   REFERENCES orders(order_id)
-- 		ON DELETE CASCADE
-- 		ON UPDATE CASCADE,

-- 	FOREIGN KEY (product_id) REFERENCES products(product_id)
-- 		ON DELETE SET NULL
-- 		ON UPDATE CASCADE,

-- 	PRIMARY KEY (id)
-- );

INSERT INTO store.images (product_id, image_path, image_alt, image_cap) VALUES
-- Chairman
(1, "/foxstore/img/chairman.jpg", "image of Cave Johnson the best Chairman of them all", "Cave Johnson"),
(1, "/foxstore/img/the_chair.png", "the most powerful chair in existance", "THE CHAIR"),
(2, "/foxstore/img/toothbrush.webp", "a toothbrush that could havegone to the moon", "brush brush, much rocket");

COMMIT;

