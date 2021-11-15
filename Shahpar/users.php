<?php
session_start();
require_once 'components/db_connect.php';
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
//if session user exist it shouldn't access dashboard.php
if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit;
}

$id = $_SESSION['adm'];
$status = 'adm';
$sql = "SELECT * FROM user WHERE status != '$status'";
$result = mysqli_query($connect, $sql);

//this variable will hold the body for the table
$tbody = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $tbody .= "<tr>
            <td><img class='img-thumbnail rounded-circle' src='pictures/" . $row['picture'] . "' alt=" . $row['first_name'] . "></td>
            <td>" . $row['first_name'] . " " . $row['last_name'] . "</td>
            <td>" . $row['date_of_birth'] . "</td>
            <td>" . $row['email'] . "</td>
            <td><a href='update.php?id=" . $row['id'] . "'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
            <a href='delete.php?id=" . $row['id'] . "'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a></td>
         </tr>";
    }
} else {
    $tbody = "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adm-DashBoard</title>
    <?php require_once 'components/boot.php' ?>
    <style type="text/css">
        .navbar-light {
            background-color: #2b7de2;
            color: white;
        }

        .manageUser {
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
                                <a class="nav-link active c-is-active" aria-current="page" href="users.php">Users</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" href="product.php">Products</a>
                            </li>



                            <li class="nav-item justify-content-end">
                                <a class="nav-link active" aria-current="page" href="logout.php?logout">Sign Out</a>
                            </li>

                        </ul>

                    </div>
            </div>
        </nav>
    </header>

    <!-- Main content -->
    <main>
        <div class="container">
        <div class="mt-2">
        <div class="manageUser w-75 mt-3">
                <p class='h2'>Users</p>
                <table class='table table-striped'>
                    <thead class='table-success'>
                        <tr>
                            <th>Picture</th>
                            <th>Name</th>
                            <th>Date of birth</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $tbody ?>
                    </tbody>
                </table>
            </div>
        </div>

           
        </div>
    </main>

</body>

</html>