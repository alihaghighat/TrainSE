<?php
ob_start();
session_start();

require_once "Database/functions.php";
require_once "Constants/db_queries.php";
require_once "Constants/db_names.php";
require_once "Constants/messages.php";
require_once "functions.php";

//Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["user"])) {
    header("location: index.php");
    exit;
}
// if ($_SESSION['user_role'] != DB_ROLE_OWNER && $_SESSION['user_role'] != DB_ROLE_ADMIN) {
//     header("location: index.php");
//     exit;
// }

if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    header("location: login.php");
}

function fetch_all_fields()
{

    return select(QUERY_ALL_FIELDS, "", []);
}

$all_fields = fetch_all_fields();
//print_r($all_fields);

$success_msg = "";

if (isset($_GET['topicSuggestID'])){

    $suggested_topic_attrs = select(QUERY_FETCH_SUGGEST_TOPIC_ATTRS_BY_ID,"i",[intval($_GET['topicSuggestID'])])[0];
}



if (isset($_POST["submit_btn"])) {

    $field_or_topic_title = $_POST["fieldOrTopicTitle"];
    $field_or_topic_date = $_POST["DateCategory"];
    $topic_field = $_POST["fieldSelector"];
    //echo($topic_field);

    if (!empty($_FILES["categoryIcon"]["name"])) {

        $imgName = generateRandomString() . "_" . $_SESSION['user'] . "_";
        $imgName .= basename($_FILES["categoryIcon"]["name"]);

        $target_dir = "uploads/";
        $target_file = $target_dir . $imgName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image

        $check = getimagesize($_FILES["categoryIcon"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

// Check file size
        if ($_FILES["categoryIcon"]["size"] > 40000000) {
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
            if (move_uploaded_file($_FILES["categoryIcon"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["categoryIcon"]["name"])) . " has been uploaded.";
                if ($topic_field == "Root") {
                    if (manipulate(QUERY_ADD_FIELD, "sss", [$field_or_topic_date, $field_or_topic_title, $imgName]) === 1) {
                        $success_msg = '<div id="success"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert alert-success  " >' . SUCCESS_FIELD_ADDED . '</div>';
                    }
                } else {
                    $field_id = select(QUERY_GET_FIELD_ID_BY_TITLE, "s", [$topic_field]);
                    if (manipulate(QUERY_ADD_TOPIC, "siss", [$field_or_topic_date, $field_id[0][0], $field_or_topic_title, $imgName]) === 1) {
                        $success_msg = '<div id="success"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert alert-success  " >' . SUCCESS_TOPIC_ADDED . '</div>';
                    }
                }

            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

    } else {
        $imgName = "field_topic_default.png";
        if ($topic_field == "Root") {
            if (manipulate(QUERY_ADD_FIELD, "sss", [$field_or_topic_date, $field_or_topic_title, $imgName]) === 1) {
                $success_msg = '<div id="success"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert alert-success  " >' . SUCCESS_FIELD_ADDED . '</div>';
            }
        } else {
            $field_id = select(QUERY_GET_FIELD_ID_BY_TITLE, "s", [$topic_field]);
            //print_r($field_id);
            if (manipulate(QUERY_ADD_TOPIC, "siss", [$field_or_topic_date, $field_id[0][0], $field_or_topic_title, $imgName]) === 1) {
                $success_msg = '<div id="success"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert alert-success  " >' . SUCCESS_TOPIC_ADDED . '</div>';
            }
        }
    }

    $all_fields = fetch_all_fields();

}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>TrineSE project | Add Field/Topic</title>

    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/structure.css" rel="stylesheet" type="text/css" class="structure" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link href="plugins/flatpickr/flatpickr.css" rel="stylesheet" type="text/css">
    <link href="plugins/noUiSlider/nouislider.min.css" rel="stylesheet" type="text/css">
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
                    <h3>Add Field/Topic</h3>
                </div>
            </div>
            <div class="row">
                <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
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
                                <!-- ToDo -->
                                <div class="form-row mb-4">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Title</label>
                                        <input type="text" class="form-control" id="inputEmail4" placeholder="Title" name="fieldOrTopicTitle" <?php if (isset($_GET['topicSuggestID'])){
                                            echo '
                                            value='.$suggested_topic_attrs[4].'
                                            ';

} ?>  >
                                        <div id="danger-Title"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert ">

                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="categoryRoot">Root</label>
                                        <select id="categoryRoot" class="form-control" name="fieldSelector">

                                            <?php if (isset($_GET['topicSuggestID'])){
                                            echo '
                                            <option selected>'. $suggested_topic_attrs[5] .'</option>
                                            ';

                                             }else{
                                               echo '<option selected>Root</option>';
                                             } 
                                              ?>  

                                            
                                            <?php
foreach ($all_fields as $field) {
    echo '<option>' . $field[0] . '</option>';
}
?>

                                        </select>
                                        <div id="danger-categoryRoot"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert ">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-row mb-4">
                                    <div class="form-group col-md-6">
                                        <label for="DateCategory"> Date </label>
                                        <input id="DateCategory" <?php if (isset($_GET['topicSuggestID'])){
                                            echo '
                                            value='.substr($suggested_topic_attrs[1],0,10).'
                                            ';

} ?>  name="DateCategory" class="form-control flatpickr flatpickr-input active" type="text" placeholder="2021-04-12" value="<?php echo '20'.date("y-m-d"); ?>">
                                        <div id="danger-DateCategory"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert ">

                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="custom-file-container" data-upload-id="myFirstImage">
                                            <label>Upload category Icon <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                            <label class="custom-file-container__custom-file" >
                                                <input type="file" name="categoryIcon" class="custom-file-container__custom-file__custom-file-input" accept="image/*">
                                                <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                                <span class="custom-file-container__custom-file__custom-file-control"></span>
                                            </label>
                                            <div class="custom-file-container__image-preview"></div>
                                        </div>
                                        <div id="danger-categoryIcon"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert ">

                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mt-3" name="submit_btn">submit</button>
                                 <!-- ToDo -->
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
<script src="plugins/highlight/highlight.pack.js"></script>
<script src="assets/js/custom.js"></script>
<script src="plugins/flatpickr/flatpickr.js"></script>
<script src="plugins/noUiSlider/nouislider.min.js"></script>
<script>
 var f2 = flatpickr(document.getElementById('DateCategory'), {

        dateFormat: "Y-m-d",
    });
</script>
<script src="plugins/file-upload/file-upload-with-preview.min.js"></script>

    <script>
        //First upload
        var firstUpload = new FileUploadWithPreview('myFirstImage')
        //Second upload
        var secondUpload = new FileUploadWithPreview('mySecondImage')
    </script>


</body>
</html>