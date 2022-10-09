<?php
// get user data
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

if (isset($_POST['update'])) {

    // print_r($_POST);die;

    $form_errors = [];
    // get form fields
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    if (isset($_POST['gender'])) {
        $gender = $_POST['gender'];
    }
    if (isset($_POST['recieve'])) {
        $recieve_email = 1;
    } else {
        $recieve_email = 0;
    }


    // First validation check on fields key and empty values:

    if (!isset($first_name) || empty($first_name)) {
        $form_errors['first_name_field'] = "<div> First name required </div>";
    } // first name field

    if (!isset($last_name) || empty($last_name)) {
        $form_errors['last_name_field'] = "<div> Last name required </div>";
    } // last name field

    if (!isset($email) || empty($email)) {
        $form_errors['email_field'] = "<div> Email required </div>";
    } // email field


    if (!isset($_POST['gender']) || empty($_POST['gender'])) {
        $form_errors['gender_field'] = "<div>Gender required</div>";
    } // gender field


    // Second validation check on inputs regex:
    if (empty($form_errors)) {
        $name_regex = "/^([a-zA-Z ]){3,30}$/";
        $email_regex = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
        $our_courses = ["PHP", "JavaScript", "MySQL", "HTML"];

        if (!preg_match($name_regex, $first_name)) {
            $form_errors['first_name_field'] = "<div>Invalid name</div>";
        } // first name regex validate

        if (!preg_match($name_regex, $last_name)) {
            $form_errors['last_name_field'] = "<div>Invalid name</div>";
        } // last name regex validate


        if (!preg_match($email_regex, $email)) {
            $form_errors['email_field'] = "<div>Invalid email</div>";
        } // email regex validate

        if ($gender !== "m" && $gender !== "f") {
            $form_errors['gender_field'] = "<div>Invalid gender</div>";
        } // gender value validate


    } // end of second validation


    // final update user data in database:
    if (empty($form_errors)) {
        //select email of user
        $conn = mysqli_connect($hostName, $dbUserName, $dbPass, $dbName);
        $sql = "SELECT users.email FROM users WHERE id = $user_id";
        $user_email = mysqli_query($conn, $sql)->fetch_column();
        if ($user_email !== $email) {
            // check if email already exists or not
            $email_exists = checkEmailExists($email);
            if ($email_exists) {
                $form_errors['email_field'] = "<div>Sorry this email already exists</div>";
            }
        }
    }
    if (empty($form_errors)) {
        $conn = mysqli_connect($hostName, $dbUserName, $dbPass, $dbName);
        $sql = "UPDATE users SET 
            first_name = '$first_name',
            last_name = '$last_name',
            email = '$email',
            gender = '$gender',
            recieve_emails = '$recieve_email'
            WHERE id = $user_id";

        $result = mysqli_query($conn, $sql); // update user info in database
        if ($result) {
            $successMsg = "<div class='alert alert-success text-center'> User updated successfully</div>";
            header("refresh:1.5;url=index.php");
        } else {
            $errorMsg = "<div class='alert alert-danger text-center'> Updated Failed</div>";
        }

        mysqli_close($conn);
    }
} // end of register 


function checkEmailExists($email)
{
    $hostName = "localhost";
    $dbUserName = "root";
    $dbPass = "";
    $dbName = "php_lab4";

    $conn = mysqli_connect($hostName, $dbUserName, $dbPass, $dbName);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        mysqli_close($conn);
        return true;
    } else {
        mysqli_close($conn);
        return false;
    }
} // end function of check if email already exists in database



?>
<!-- End PHP code -->

<!doctype html>
<html lang="en">

<head>
    <title>Edit user</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>


    <!-- Register Content -->
    <section>
        <div class="container">
            <a class="mt-3 mb-3 btn btn-primary" href="index.php">Home</a>

            <div class="row">
                <div class="col-12 mt-1">
                    <div class="col-12 text-center text-uppercase">
                        <h2 class="text-warning my-5">Update user</h2>
                    </div>
                </div>

                <main class="row">
                    <div id="registerErrors" class="col-lg-4 col-md-6 col-sm-8 mx-auto mb-4">
                        <div class="col-12">
                            <form id="registeration" method="POST" action="<?php $_PHP_SELF ?>">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div>
                                            <label for="first_name" class="form-label">First Name</label> <span class="text-danger">*</span>
                                            <input type="text" name="first_name" id="first_name" class="form-control 
                                                <?php
                                                echo (isset($form_errors['first_name_field'])) ? "is-invalid" : "";
                                                ?>
                                            " value="<?php echo $user->first_name; ?>">
                                            <div class="invalid-feedback">
                                                <?php
                                                echo (isset($form_errors['first_name_field'])) ? $form_errors['first_name_field'] : "";
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <label for="last_name" class="form-label">Last Name</label> <span class="text-danger">*</span>
                                            <input type="text" name="last_name" id="last_name" class="form-control
                                        <?php
                                        echo (isset($form_errors['last_name_field'])) ? "is-invalid" : "";
                                        ?>
                                        " value="<?php echo $user->last_name ?>">

                                            <div class="invalid-feedback">
                                                <?php
                                                echo (isset($form_errors['last_name_field'])) ? $form_errors['last_name_field'] : "";
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label> <span class="text-danger">*</span>
                                    <input type="text" name="email" id="email" class="form-control
                                        <?php
                                        echo (isset($form_errors['email_field'])) ? "is-invalid" : "";
                                        ?>
                                        " value="<?php echo $user->email ?>">

                                    <div class="invalid-feedback">
                                        <?php
                                        echo (isset($form_errors['email_field'])) ? $form_errors['email_field'] : "";
                                        ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 d-flex">
                                        <label for="gender" class="form-label">Gender:</label> <span class="text-danger">*</span>
                                        <div class="form-check mx-3">
                                            <input class="form-check-input" type="radio" value="m" name="gender" id="male" <?php if ($user->gender == "m") echo "checked" ?>>
                                            <label class="form-check-label" for="male">
                                                Male
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="f" name="gender" id="female" <?php if ($user->gender == "f") echo "checked" ?>>
                                            <label class="form-check-label" for="female">
                                                Female
                                            </label>
                                        </div>
                                        <div class="text-sm text-danger ms-5">
                                            <?php
                                            echo (isset($form_errors['gender_field'])) ? $form_errors['gender_field'] : "";
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" name="recieve" id="recieve_email" <?php if ($user->recieve_emails == "1") echo "checked" ?>>
                                        <label class="form-check-label" for="recieve_email">
                                            Recieve E-Mails from us.
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <button name="update" id="update" type="submit" class="btn btn-outline-warning">Update</button>
                                </div>
                            </form>
                        </div>
                        <?php
                        echo isset($successMsg) ? $successMsg : "";
                        echo isset($errorMsg) ? $errorMsg : "";
                        ?>
                    </div>
                </main>
            </div>
        </div>
    </section>
    <!-- Register Content -->


    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>