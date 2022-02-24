<?php
ob_start();

session_start();

require_once "Database/functions.php";
require_once "Constants/db_queries.php";
require_once "Constants/messages.php";
require_once "functions.php";

//Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["user"])) {
    header("location: index.php");
    exit;
}

if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    header("location: login.php");
}

function fetch_user_details()
{

    return select(QUERY_FETCH_USER_ATTRS_BY_USERNAME, "s", [$_SESSION["user"]]);
}

$user_details = fetch_user_details();

$user_username = $user_details[0][0];
$user_firstname = $user_details[0][1];
$user_lastname = $user_details[0][2];
$user_email = $user_details[0][3];
$user_imgName = $user_details[0][5];

$success_msg = "";
//$success_msg = '<div>'.SUCCESS_USER_PROFILE_EDITED.'</div>';

if (isset($_POST["save_changes"])) {

    $edited_user_firstname = $_POST["user_firstname"];
    $edited_user_lastname = $_POST["user_lastname"];
    $edited_user_email = $_POST["user_email"];

    $user_firstname = $edited_user_firstname;
    $user_lastname = $edited_user_lastname;
    $user_email = $edited_user_email;

    if (!empty($_FILES["ImageUserProfile"]["name"])) {

        $imgName = generateRandomString() . "_" . $_SESSION['user'] . "_";
        $imgName .= basename($_FILES["ImageUserProfile"]["name"]);

        $target_dir = "uploads/";
        $target_file = $target_dir . $imgName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image

        $check = getimagesize($_FILES["ImageUserProfile"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

// Check file size
        if ($_FILES["ImageUserProfile"]["size"] > 20000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

// Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["ImageUserProfile"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["ImageUserProfile"]["name"])) . " has been uploaded.";

                if (manipulate(QUERY_EDIT_USER_ATTRS, "sssss", [$edited_user_firstname, $edited_user_lastname, $edited_user_email, $imgName, $_SESSION["user"]]) === 1) {
                    $success_msg = '<div id="success"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert alert-success  " >' . SUCCESS_USER_PROFILE_EDITED . '</div>';
                    //header("Location: edit_user_profile.php");
                }

            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

    } else {
        $imgName = $user_imgName;
        if (manipulate(QUERY_EDIT_USER_ATTRS, "sssss", [$edited_user_firstname, $edited_user_lastname, $edited_user_email, $imgName, $_SESSION["user"]]) === 1) {
            $success_msg = '<div id="success"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert alert-success  " >' . SUCCESS_USER_PROFILE_EDITED . '</div>';
            //header("Location: edit_user_profile.php");
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>TrineSE project | User Profile</title>

    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/structure.css" rel="stylesheet" type="text/css" class="structure" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link href="assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />

</head>
<body class="dashboard-analytics">

<?php
require_once "dashboard_menu.php";
?>

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="page-header">
                <div class="page-title">
                    <h3>User Profile</h3>
                </div>
            </div>
            <div class="row">
                <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div  class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4></h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">

                                <?php if (!empty($success_msg)) {
    echo $success_msg;
}
?>



                            <form method="post" enctype="multipart/form-data">
                                <div class="form-row mb-4">
                                    <div class="form-group col-md-6">
                                        <label for="Username">Username</label>
                                        <input type="text" disabled class="form-control" id="Username" value="<?php echo $user_username; ?>" placeholder="Title">
                                        <div id="danger-username"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert ">

                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Username">Email</label>
                                        <input type="email"  class="form-control" id="Email" value="<?php echo $user_email; ?>" placeholder="Title" name="user_email">
                                        <div id="danger-Email"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert ">

                                        </div>
                                    </div>

                                </div>
                                <div class="form-row mb-4">
                                    <div class="form-group col-md-6">
                                        <label for="FirstName">FirstName</label>
                                        <input type="text"  class="form-control" id="FirstName" value="<?php echo $user_firstname; ?>" placeholder="Title" name="user_firstname">
                                        <div id="danger-FirstName"  class="col-xl-12 mt-2 col-md-12 col-sm-12 col-12 alert ">

                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="LastName">LastName</label>
                                        <input type="text"  class="form-control" id="LastName" value="<?php echo $user_lastname; ?>" placeholder="Title" name="user_lastname">
                                        <div id="danger-LastName"  class="col-xl-12 mt-2 col-md-12 col-sm-12 col-12 alert ">

                                        </div>
                                    </div>

                                </div>
                                <div class="form-row mb-4">
                                    <div class="custom-file-container" data-upload-id="myFirstImage">
                                        <label>Upload Profile Image <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                        <label class="custom-file-container__custom-file" >
                                            <input type="file" name="ImageUserProfile" class="custom-file-container__custom-file__custom-file-input" accept="image/*">
                                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                                        </label>
                                        <div class="custom-file-container__image-preview"></div>
                                    </div>
                                    <div id="danger-ImageUserProfile"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert ">

                                    </div>

                                </div>


                                <button type="submit" class="btn btn-primary mt-3" name="save_changes">Save changes</button>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-wrapper">
            <div class="footer-section f-section-1">
                <p class="">Copyright © 2021 <a target="_blank" href="https://TrineSE.ir">TrineSE</a>, All rights reserved.</p>
            </div>

        </div>
    </div>
    <!--  END CONTENT AREA  -->


</div>
<!-- END MAIN CONTAINER -->

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="assets/js/app.js"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="plugins/apex/apexcharts.min.js"></script>
<script src="assets/js/dashboard/dash_1.js"></script>
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="plugins/file-upload/file-upload-with-preview.min.js"></script>

<script>
    //First upload
    var firstUpload = new FileUploadWithPreview('myFirstImage')
    //Second upload
    var secondUpload = new FileUploadWithPreview('mySecondImage')
</script>
</body>
</html>


