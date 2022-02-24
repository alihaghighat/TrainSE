<?php

require "./Database/functions.php";
require "./Constants/db_queries.php";
require "./Constants/messages.php";
ob_start();
session_start();
if (isset($_SESSION['user'])) {

    header("location: main_page.php");
}

$login_err = "";

if (isset($_POST["login"])) {

    $param_username = $_POST['username'];
    $hashed_password = md5($_POST['password']);

    $result = select(QUERY_LOGIN_USER, "ss", [$param_username, $param_username]);

    // print_r(strcmp($hashed_password, $result[0][1]));
    if ($result != null && strcmp($hashed_password, $result[0][1]) == 0) {
        $_SESSION['user_role'] = $result[0][2];
        $_SESSION["user"] = $result[0][0];

        header("location: main_page.php");

    } else {
        $login_err = '<div class="alert alert-danger" role="alert">' . ERR_INVALID_LOGIN . '</div>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="./CSS/style.css">
    <link
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
            rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
            href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
            rel="stylesheet"
    />
    <!-- MDB -->
    <link
            href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.0/mdb.min.css"
            rel="stylesheet"
    />
</head>
<body>

<section class="vh-100 bg-image" style="background-image: url('https://mdbootstrap.com/img/Photos/new-templates/search-box/img4.jpg');">
    <div class="mask d-flex align-items-center h-100 gradient-custom-3">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-5">
                            <h3 class="text-uppercase text-center mb-5">Login Page</h3>

                            <?php echo $login_err; ?>

                            <form method="post" name="login">

                                <div class="form-outline mb-4">
                                    <input type="text" id="Tusername" name="username" class="form-control form-control-lg" aria-describedby="validationFeedbackUser" required/>
                                    <label class="form-label" for="Tusername">Username</label>
                                </div>


                                <div class="form-outline mb-4">
                                    <input type="password" id="Tpassword" name="password" class="form-control form-control-lg" aria-describedby="validationFeedbackPassword" required/>
                                    <label class="form-label" for="Tpassword">Password</label>
                                </div>


                                <div class="text-center text-lg-start mt-4 pt-2">
                                    <button type="submit" name="login" class="btn btn-primary btn-lg gradient-custom-4"
                                            style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                                    <p class="small fw-bold mt-4 pt-1 mb-0">Don't have an account? <a href="signup.php"
                                                                                                      class="link-danger">Register</a></p>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script
        type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.0/mdb.min.js"
></script>
</body>
</html>
