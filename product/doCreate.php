<?php

require_once("../db_connect.php");

// 取得商品表單資訊
$name = $_POST["name"];
$cate_1 = $_POST["category_1"];
$cate_2 = $_POST["category_2"];
$price = $_POST["price"];
$img = $_POST["img"];
$description = $_POST["description"];
$quantity = $_POST["quantity"];
$brand = $_POST["brand"];
$is_groupBuy = isset($_POST["is_groupBuy"]) ? 1 : 0;

// 取得類別
// 類別一
$sqlCategory1 = "SELECT c1_id FROM category_1 WHERE name = '$cate_1'";
$resultCate1 = $conn->query($sqlCategory1);
$cate_1 = $resultCate1->fetch_assoc()["c1_id"];
// 類別二
$sqlCategory2 = "SELECT c2_id FROM category_2 WHERE name = '$cate_2'";
$resultCate2 = $conn->query($sqlCategory2);
$cate_2 = $resultCate2->fetch_assoc()["c2_id"];

// echo $name . "<br>";
// echo $cate_1 . "<br>";
// echo $cate_2 . "<br>";
// echo $price . "<br>";
// echo $img . "<br>";
// echo $description . "<br>";
// echo $quantity . "<br>";
// echo $brand . "<br>";
// echo $is_groupBuy . "<br>";
// echo $start . "<br>";
// echo $end . "<br>";
// echo $target_people . "<br>";

// 新增商品操作
// 插入商品資料
$sql1 = "ALTER TABLE product AUTO_INCREMENT = 1;";

$sql1 .= "INSERT INTO product (name, category_1, category_2, img, price, quantity, brand, is_groupBuy, valid, description)
    VALUE ('$name', '$cate_1', '$cate_2', '$img', '$price', '$quantity', '$brand', '$is_groupBuy', 1, '$description');";

// 假如為團購商品，就需要新增資訊進團購商品資料表


if ($conn->multi_query($sql1) === TRUE) {
    // 取得資料表新增當下的 id
    $latestId = $conn->insert_id;
    if ($is_groupBuy == 1) {
        $start = $_POST["start"];
        $end = $_POST["end"];
        $target_people = $_POST["target_people"];
        // 插入團購資訊
        $sql2 = "ALTER TABLE group_buy AUTO_INCREMENT = 1;";
        $sql2 .= "INSERT INTO group_buy (product_id, start, end, target_people, current_people)
                  VALUE ('$latestId', '$start', '$end', '$target_people', 0);";
    }
    // 資料庫操作成功 回到指定的頁面
    header("location: create_user.php");
} else {
    echo "新增資料錯誤: " . $conn->error;
}

// 利用事務的方式做
$conn->begin_transaction();
try {
    // 插入商品資料
    $sql1 = "ALTER TABLE product AUTO_INCREMENT = 1;";

    $sql1 .= "INSERT INTO product (name, category_1, category_2, img, price, quantity, brand, is_groupBuy, valid, description)
    VALUE ('$name', '$cate_1', '$cate_2', '$img', '$price', '$quantity', '$brand', '$is_groupBuy', 1, '$description');";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute();

    $product_id = $conn->insert_id;

    if ($is_groupBuy === 1) {
        $start = $_POST["start"];
        $end = $_POST["end"];
        $target_people = $_POST["target_people"];
        // 插入團購資訊
        $sql2 = "ALTER TABLE group_buy AUTO_INCREMENT = 1;";
        $sql2 .= "INSERT INTO group_buy (product_id, start, end, target_people, current_people)
                  VALUE ('$product_id', '$start', '$end', '$target_people', 0);";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute();
    }
    // 提交事務
    $conn->commit();

    echo "成功新增";
} catch (Exception $e) {
    // 錯誤就回滾事務
    $conn->rollback();
    echo "新增失敗" . $e->getMessage();
}

$conn->close();
