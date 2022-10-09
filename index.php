<?php
$hostName = "localhost";
$dbUserName = "root";
$dbPass = "";
$dbName = "php_lab4";
$conn = mysqli_connect($hostName, $dbUserName, $dbPass);
//create database if not exists
// $sql = "CREATE DATABASE IF NOT EXISTS $dbName;";
// mysqli_query($conn, $sql);
$conn = mysqli_connect($hostName, $dbUserName, $dbPass, $dbName);

$sql = "SELECT * FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if ($result) {
    $user;
}

mysqli_close($conn);

?>
<!doctype html>
<html lang="en">

<head>
    <title>All users</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        table {
            padding: 15px;
            font-size: 1.4rem;
        }
    </style>
</head>

<body>


    <!-- Application Content -->
    <section class="mt-5">
        <div class="container">
            <h1 class="text-center text-dark mb-5">All users</h1>
            <a class="mt-3 mb-3 btn btn-success" href="add.php">New user</a>

            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Recieve emails</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $id = 0;
                    while ($user = mysqli_fetch_assoc($result)) {
                        $id++;
                    ?>
                        <tr>
                            <td><?= $id ?></td>
                            <td><?= $user["first_name"] ?></td>
                            <td><?= $user["last_name"] ?></td>
                            <td><?= $user["email"] ?></td>
                            <td>
                                <?php
                                if ($user["gender"] == "m") {
                                    echo "Male";
                                } else {
                                    echo "Female";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($user["recieve_emails"] == 1) {
                                    echo "Yes";
                                } else {
                                    echo "No";
                                }
                                ?>
                            </td>

                            <td>
                                <a class="text-secondary" title="show" href="user.php?user=<?= $user["id"]?>"><i class="fa-regular fa-eye"></i></a>
                                <a class="text-warning" title="edit" href="edit.php?user=<?= $user["id"]?>"><i class="fa-regular fa-pen-to-square"></i></a>
                                <a class="text-danger" onclick="return confirm('are you sure?')" title="delete" href="delete.php?user=<?= $user["id"]?>"><i class="fa-regular fa-trash-can"></i></a>
                            </td>

                
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Application Content -->


    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>