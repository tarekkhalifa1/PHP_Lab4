<?php
if ($_GET['user'] && is_numeric($_GET['user'])) {
    $user_id = $_GET['user'];

    $hostName = "localhost";
    $dbUserName = "root";
    $dbPass = "";
    $dbName = "php_lab4";
    $conn = mysqli_connect($hostName, $dbUserName, $dbPass, $dbName);
    $sql = "SELECT * FROM users WHERE id = $user_id ";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $user = mysqli_fetch_object($result);
    }

    mysqli_close($conn);
} else {
    echo "moshkla";
    die;
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>User Info</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>


    <!-- User Content -->
    <section class="user">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-1">
                    <div class="col-12 text-center text-uppercase">
                        <h2 class="text-primary my-5">Welcome</h2>
                    </div>
                    <div class="col-12 text-center mb-4">
                    <img src="imgs/user.png" width="200" alt="">
                </div>
                </div>

                <main class="row">
                    <div class="col-lg-4 col-md-6 col-sm-8 mx-auto mb-4">
                        <div class="col-12">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div>
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input disabled type="text" name="first_name" id="first_name" class="form-control " value="<?= $user->first_name ?>">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input disabled type="text" name="last_name" id="last_name" class="form-control " value="<?= $user->last_name ?>">
                                    </div>
                                </div>
                            </div>


                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input disabled id="last_name" class="form-control " value="<?= $user->email ?>">
                            </div>

                            <div class="row">
                                    <div class="form-check mb-3">
                                        <?php
                                        if ($user->gender == "m") {
                                        ?>
                                            <label class="form-check-label">
                                                Gender: Male
                                            </label>
                                        <?php } else { ?>
                                            <label class="form-check-label">
                                            Gender: Female
                                            </label>
                                        <?php } ?>
                                </div>
                            </div>

                            <div class="mb-3">

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" <?php
                                                                                    if ($user->recieve_emails) {
                                                                                        echo "checked";
                                                                                    } else {
                                                                                        echo "";
                                                                                    }
                                                                                    ?>>
                                    <label class="form-check-label" for="recieve_email">
                                        Recieve E-Mails from us.
                                    </label>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <a class="btn btn-outline-primary me-3" href="index.php">Back</a>
                                <a href="edit.php?user=<?= $user->id ?>">Want to update?</a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
    <!-- User Content -->


    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>