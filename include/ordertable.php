<?php
$isAdminpage = str_contains($_SERVER['REQUEST_URI'],"admin");
if ($query->rowCount() == 0) {
    echo "<p>You got no orders! Go buy stuff</p>";
    return;
}
?>

<table class="ordertable">
    <tr>
        <td>order id</td>
        <?php if ($isAdminpage): ?>
        <td>customer</td>
        <?php endif;?>
        <td>total products</td>
        <td>total price</td>
        <td>time</td>
        <td>status</td>
    </tr>
    <?php
        while(($row = $query->fetch())) {
            $order_id = $row["order_id"];
            $time = $row["time"];
            $total_products = $row["total_products"];
            $total_price = $row["total_price"];
            $customer = $row["username"];
            $status = $row["status"];
            $nextstatus = ["unpaid" => "paid", "paid" => "packaged", "packaged" => "delivered", "delivered" => ""][$status];
            $statuscolor = ["unpaid" => "red", "paid" => "orange", "packaged" => "yellow", "delivered" => "lime"][$status];
            
            echo "<tr id='order_$order_id'>";
            echo "<style>
                #order_$order_id::before {
                    background-color: $statuscolor;
                }
            </style>";
            echo "<td>$order_id</td>";
            if ($isAdminpage) {
                echo "<td>$customer</td>";
            }
            echo "<td>$total_products</td>";
            echo "<td>$$total_price</td>";
            echo "<td>$time</td>";
            echo "<td>";
            echo "<span>$status</span>";
            if ($nextstatus != "" && $isAdminpage) {
                echo "<form action='setorderstatus.php' method='post'>";
                echo "<button name='status' value='$nextstatus'>> $nextstatus</button><input type='hidden' name='oid' value='$order_id'></form>";
            }
            echo "</td>";
            echo "</tr>";
        }
    ?>
</table>
