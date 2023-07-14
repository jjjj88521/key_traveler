<?php
require_once("db_connect_small_project.php");
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

$id = $_GET["id"];
$account = $_POST["account"];
$password = $_POST["password"];
$email = $_POST["email"];
$conn->query("UPDATE `users` SET `account`='$account',`password`='$password',`email`='$email' WHERE id=$id ");
// echo $id . '<br>', $account . '<br>', $password . '<br>', $email;
?>
<!doctype html>
<html lang="en">

<head>
    <title>doUpdate</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body class="">

    <div class="container d-flex justify-content-center flex-column">
        <a class="navbar-brand ps-3 bg-dark pb-3 rounded mt-3" href="dashboard.php"> <img class="w-25 d-block mx-auto mt-3" src="橫logo白.svg" alt=""></a>
        <div class="card-body">
            <div class="small mb-3 text-muted mt-3">
                <h5>更新資料完成，資料如下:</h5>
            </div>
            <div class="py-2 container">
                <table class="table table-bordered table-striped border-5  col-8">
                    <tr class="row">
                        <td class="col">Account</td>
                        <td class="col"><?= $account ?></td>
                    </tr>
                    <tr class="row">
                        <td class="col">Password</td>
                        <td class="col"><?= $password ?></td>
                    </tr>
                    <tr class="row">
                        <td class="col">Email</td>
                        <td class="col"><?= $email ?></td>
                    </tr>

                </table>
            </div>
        </div>

        <div class="card-footer text-center py-3">
            <div class="small"><a href="dashboard.php" class="text-dark">Go to dashboard</a></div>
        </div>
    </div>


</body>

</html>