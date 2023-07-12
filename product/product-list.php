<?php
$parentTitle = "商品管理";
$title = "商品列表";

require_once("../db_connect.php");
// 找商品的資訊
$sql = "SELECT product.*, category_1.name AS c1_name, category_2.name AS c2_name
        FROM product
        JOIN category_1 ON product.category_1 = category_1.c1_id
        JOIN category_2 ON product.category_2 = category_2.c2_id
        WHERE valid = 1 AND is_groupBy = 0
        ORDER BY id ASC";
$result = $conn->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);

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
                    <h1 class="mt-4"><?= $title ?></h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><?= $parentTitle ?></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                    <div class="card mb-4">
                        <!-- 主要表格 -->
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>商品名稱</th>
                                        <th>品牌</th>
                                        <th>商品類別</th>
                                        <th>商品價格</th>
                                        <th>商品庫存</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $product) : ?>
                                        <tr>
                                            <td><?= $product["id"] ?></td>
                                            <td>
                                                <?= $product["name"] ?>
                                            </td>
                                            <td><?= $product["brand"] ?></td>
                                            <td><?= $product["c1_name"] ?> / <?= $product["c2_name"] ?></td>
                                            <td><?= $product["price"] ?></td>
                                            <td><?= $product["quantity"] ?></td>
                                            <td>
                                                <a href="product.php?mode=info&id=<?= $product["id"] ?>" title="詳細資訊"><i class="fa-solid fa-circle-info"></i></a>
                                                <a href="product.php?mode=edit&id=<?= $product["id"] ?>" title="編輯"><i class="fa-solid fa-pen-to-square"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
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