<?php
  require './includes/db_mod.php';
 $query = $db->query("INSERT INTO Products (`name`, `description`, `price`, `stock`) 
                    VALUES ('Fox999','test',200000,'20')");
for ($x = 0;$x <= 50;$x++) { 
$query = $db->query("INSERT INTO Products (`name`, `description`, `price`, `stock`) 
                    VALUES ('Fox$x','test',20$x,'20')");
 };
?>