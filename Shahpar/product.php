<?php
require_once 'components/db_connect.php';
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit;
}

$sql = "SELECT * FROM products";
$result = mysqli_query($connect, $sql);
$tbody = ''; //this variable will hold the body for the table
if (mysqli_num_rows($result)  > 0) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $tbody .= "<tr>
            <td><img class='img-thumbnail' src='pictures/" . $row['picture'] . "'</td>
            <td>" . $row['name'] . "</td>
            <td>" . $row['price'] . "</td>
            <td><a href='product_update.php?id=" . $row['id'] . "'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
            <a href='product_delete.php?id=" . $row['id'] . "'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a></td>
            </tr>";
    };
} else {
    $tbody =  "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD</title>
    <?php require_once 'components/boot.php' ?>
    <style type="text/css">
        .navbar-light {
            background-color: #2b7de2;
            color: white;
        }

        .manageProduct {
            margin: auto;
        }

        .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }

        td {
            text-align: left;
            vertical-align: middle;
        }

        tr {
            text-align: center;
        }

        .userImage {
            width: 100px;
            height: auto;
        }
    </style>
</head>

<body>

    <header>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light pt-3 pb-3">

            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"><a class="navbar-brand" href="#">
                        <img src="pictures/admavatar.png" alt="" width="30" height="24" class="d-inline-block align-text-top rounded-circle border border-warning"> Admin Dashboard
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100 justify-content-center">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" href="users.php">Users</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active  c-is-active" aria-current="page" href="product.php">Products</a>
                            </li>

                            <li class="nav-item justify-content-end">
                                <a class="nav-link active" aria-current="page" href="logout.php?logout">Sign Out</a>
                            </li>

                        </ul>

                    </div>
            </div>
        </nav>
    </header>

    <div class="container">


        <div class="mt-2">
            <div class="manageProduct w-75 mt-3">
                <div class='mb-3'>
                    <a href="product_create.php"><button class='btn btn-primary' type="button">Add product</button></a>
                </div>
                <p class='h2'>Products</p>
                <table class='table table-striped'>
                    <thead class='table-success'>
                        <tr>
                            <th>Picture</th>
                            <th>Name</th>
                            <th>price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $tbody; ?>
                    </tbody>
                </table>
            </div>

        </div>

</body>

</html>