<?php
$parentTitle = "商品管理";
$title = "商品列表";

if (!isset($_GET["id"])) {
    // die("資料不存在");
    header("location: ../404.php");
}

$product_id = $_GET["id"];

require_once("../db_connect.php");
// 找商品的資訊
$sql = "SELECT product.*, category_1.name AS c1_name, category_2.name AS c2_name
        FROM product
        JOIN category_1 ON product.category_1 = category_1.id
        JOIN category_2 ON product.category_2 = category_2.id
        WHERE product.id = $product_id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <!-- navbar -->
    <?php include("../template/navbar.php") ?>
    <div id="layoutSidenav">
        <!-- sideBar -->
        <?php include("../template/sideBar.php"); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">商品 <?= $product_id ?> 詳細資訊</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><?= $parentTitle ?></li>
                        <li class="breadcrumb-item"><?= $title ?></li>
                        <li class="breadcrumb-item active">商品 <?= $product_id ?></li>
                    </ol>
                    <div class="row">
                        <!-- 圖檔放在images/product數字，數字為類別一 -->
                        <figure>
                            <img src="../images/product<?= $product["category_1"] ?>/<?= $product["img"] ?>" alt="">
                        </figure>
                        <table class="table table-bordered">
                            <tr>
                                <th>商品名稱</th>
                                <td><?= $product["name"] ?></td>
                            </tr>
                            <tr>
                                <th>品牌</th>
                                <td><?= $product["brand"] ?></td>
                            </tr>
                            <tr>
                                <th>商品類別</th>
                                <td><?= $product["c1_name"] ?> / <?= $product["c2_name"] ?></td>
                            </tr>
                            <tr>
                                <th>商品價格</th>
                                <td><?= $product["price"] ?></td>
                            </tr>
                            <tr>
                                <th>商品庫存</th>
                                <td><?= $product["quantity"] ?></td>
                            </tr>
                            <tr>
                                <th>商品描述</th>
                                <td><?= $product["description"] ?></td>
                            </tr>
                            <tr>
                                <th>上下架狀態</th>
                                <td>
                                    <?php if ($product["valid"] == 1) : ?>
                                        <span class="text-success">
                                            <i class="fa-solid fa-check"></i> 上架
                                        </span>
                                    <?php else : ?>
                                        <span class="text-danger">
                                            <i class="fa-solid fa-xmark"></i> 下架
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </main>
            <!-- footer -->
            <?php include("../template/footer.php") ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
</body>

</html>