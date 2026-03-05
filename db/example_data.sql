START TRANSACTION;

INSERT INTO store.users (user_type, username, password) VALUES
-- user : "admin", pass: "elvis"
("admin", "admin", 0x243279243130243143703973494643325444484d507433593658647675707a6b784c4d5671335654766c68324359476f745a577a3258746f547a4736),
-- user : "marie", pass: "123"
("customer", "marie", 0x243279243130244553705767317449364331394133546b5178416e614f362f303865467343646f54372f517276496642716d6239754b31774b565565);


INSERT INTO store.products (name, description, price, stock) VALUES
("Example Product 1 Chairman", "Chairman, a gentelman that Shares with the people without position. The Chairman is mostly made out of Wood, please don't mind it. IKEA made them like this.\nThis is a Example Description for Example product 1 written in the example_data.sql file.", 13.37, 10),
("Example Product 2 Toothbrush", "“... TOOTHBRUSH IN THE JAW TOOTHBRUSH BRUSH BRUSH tooth jaw foam dome in the foam Roman dome come home home in the jaw Rome dome tooth toothbrush toothpick pickpocket socket rocket ...” - Aynrand the fountainhead.\nThis is a Example Description for Example product 2 written in the example_data.sql file. ", 10, 1),
("/dev/null", "dd if=/dev/urandom of=/dev/null bs=4096 prog=status", 1.11, 99999),
("/bin/sh", "she shells sea shells on the sea shore, waiting for the stock to soar", 0, 99999),
("ffmpeg", "ffmpeg my beloved", 0, 99999);

INSERT INTO store.comments (user_id,product_id, rating, comment_desc) VALUES
(1,1,5,"Ya know, i wandered many hills, many mires. Thwy said they could offer the finest of fluffs. I didn't want a damn bone! Pretty, squishy, mind you. -Rowan"),
(2,1,4,"it sucks to write comments"),
(2,1,3,"it sucks to write comments");

INSERT INTO store.images (product_id, image_path, image_alt, image_cap) VALUES
-- Chairman
(1, "./example/chairman.jpg", "image of Cave Johnson the best Chairman of them all", "Cave Johnson"),
(1, "./example/the_chair.png", "the most powerful chair in existance", "THE CHAIR"),
(2, "./example/toothbrush.webp", "a toothbrush that could havegone to the moon", "brush brush, much rocket");
COMMIT;

