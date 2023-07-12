<?php
require_once("../db_connect.php");

// 接商品的資訊
$id = $_POST["id"];
$name = $_POST["name"];
$brand = $_POST["brand"];
$price = $_POST["price"];
$description = $_POST["description"];
$quantity = $_POST["quantity"];
$valid = isset($_POST["valid"]) ? 1 : 0;

// var_dump($_POST);

// 修改商品資訊
$sql = "UPDATE product
        SET name='$name', brand='$brand', price='$price', description='$description', quantity='$quantity', valid='$valid'
        WHERE id=$id";
if ($conn->query($sql) === TRUE) {
    header("location: product.php?mode=info&id=" . $id);
} else {
    echo "資料修改錯誤: " . $conn->error;
}

$conn->close();
