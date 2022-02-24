<?php

include "./Database/functions.php";
include "./Constants/db_queries.php";
include "./Constants/messages.php";
ob_start();

session_start();

if (isset($_SESSION['user'])) {
    header("location: main_page.php");
}

if (isset($_POST["signup"])) {

    // Processing form data when form is submitted

    $username = trim($_POST["username"]);

    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $password = md5($password);

    if ((manipulate(QUERY_SIGNUP_USER, "ssssss", [$username, $first_name, $last_name, $email, $password, DB_ROLE_STD]) == 1)) {
        if (manipulate(QUERY_CREATE_STD, "s", [$username]) == 1) {
            $_SESSION["user"] = $username;
            $_SESSION['user_role'] = DB_ROLE_STD;
            header("location: main_page.php");
        } else {
            echo "Oops! Something went wrong. Please try again later.";

        }
    } else {

        echo "Oops! Something went wrong. Please try again later.";
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SignUp Page</title>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<?php include "./validation.php";?>

<section class="vh-100 bg-image" style="background-image: url('https://mdbootstrap.com/img/Photos/new-templates/search-box/img4.jpg');">
    <div class="mask d-flex align-items-center h-100 gradient-custom-3">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-5">
                            <h3 class="text-uppercase text-center mb-5">Create an account</h3>


                            <form method="post" name="signup" id="signup_form">

                                <div class="form-outline mb-4">
                                    <input type="text" id="Tusername" name="username" onkeyup="usernameValidation(this)" class="form-control form-control-lg" aria-describedby="validationFeedbackUser" required/>
                                    <label class="form-label" for="Tusername">Username</label>
                                    <div id="validationFeedbackUser" class="invalid-feedback">
                                    <?php echo ERR_USERNAME_TAKEN; ?>
                                    </div>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="text" id="Tfirstname" name="first_name" onkeyup="nameValidation(this)" class="form-control form-control-lg" required/>
                                    <label class="form-label" for="Tfirstname">FirstName</label>
                                    <div id="validationFeedbackUser" class="invalid-feedback">
                                    <?php echo ERR_INVALID_NAME; ?>
                                    </div>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="text" id="Tlastname" name="last_name" onkeyup="nameValidation(this)" class="form-control form-control-lg" required/>
                                    <label class="form-label" for="Tlastname">LastName</label>
                                    <div id="validationFeedbackUser" class="invalid-feedback">
                                        <?php echo ERR_INVALID_NAME; ?>
                                    </div>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="email" id="Temail" name="email" onkeyup="emailValidation(this)" class="form-control form-control-lg" aria-describedby="validationFeedbackEmail" required/>
                                    <label class="form-label" for="Temail">Email</label>
                                    <div id="emailvalidationFeedbackUser" class="invalid-feedback">

                                    </div>
                                </div>

                                <div  class="form-outline mb-4">
                                    <input type="password" id="Tpassword" name="password" onkeyup="passwordValidation(this)" class="form-control form-control-lg" aria-describedby="validationFeedbackPassword" required/>
                                    <label class="form-label" for="Tpassword">Password</label>
                                    <div id="dvalidationFeedbackUser"  class="invalid-feedback">
                                    <?php echo ERR_INVALID_PWD; ?>
                                    </div>
                                </div>


                                <div class="form-outline mb-4">
                                    <input type="password" id="Tconfirm_password" name="confirm_password" onkeyup="confirmPassValidation(this)" class="form-control form-control-lg" aria-describedby="validationFeedbackConfirmPassword" required/>
                                    <label class="form-label" for="Tconfirm_password">Confirm Password</label>
                                    <div id="validationFeedbackUser" class="invalid-feedback">
                                    <?php echo ERR_MISMATCH_PWD; ?>
                                    </div>
                                </div>

                                <button type="submit" name="signup" style="display:none" id="submit_form_btn" >

                                <div class="d-flex justify-content-center">

                                    <button type="button" id="form_sbmit_btn" onclick="formValidate()"  class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Register</button>
                                </div>

                                <p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="login.php" class="fw-bold text-body"><u>Login here</u></a></p>

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
