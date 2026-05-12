<?php

include '../../config/database.php';

$id = (int)$_GET['id'];

$sql = "
    SELECT orders.*, solar_panels.name AS product_name
    FROM orders
    INNER JOIN solar_panels
    ON orders.product_id = solar_panels.id
    WHERE orders.id = $id
";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){

    $order = mysqli_fetch_assoc($result);

    echo json_encode([
        'success' => true,
        'order' => $order
    ]);

}else{

    echo json_encode([
        'success' => false
    ]);
}
?>