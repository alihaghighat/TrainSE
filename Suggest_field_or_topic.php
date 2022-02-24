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
    header("location: main_page.php");
    exit;
}
if ($_SESSION['user_role'] != DB_ROLE_OWNER && $_SESSION['user_role'] != DB_ROLE_ADMIN && $_SESSION['user_role'] != DB_ROLE_CC) {
    header("location: main_page.php");
    exit;
}

if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    header("location: login.php");
}

function fetch_all_fields()
{

    return select(QUERY_ALL_FIELDS, "", []);
}

$all_fields = fetch_all_fields();

$success_msg = "";


if (isset($_POST['submit_btn'])) {

    $topic_title = $_POST['fieldOrTopicTitle'];
    $topic_date = $_POST['DateCategory'];
    $field_title = $_POST['fieldSelector'];
    $topic_description = $_POST['Description'] ;
    $suggester_id = select(QUERY_GET_CC_ID_BY_USERNAME,"s",[$_SESSION["user"]])[0][0];

    if(manipulate(QUERY_ADD_NEW_TOPIC_SUGGEST, "siissss", [$topic_date, null , $suggester_id , $topic_title , $field_title , 'unchecked' , $topic_description]) == 1){
        $success_msg = '<div id="success"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert alert-success  " >' . SUCCESS_TOPIC_SUGGEST . '</div>';
    }

}


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>TrineSE project | Suggest Topic</title>

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
                    <h3>Suggest  Topic</h3>
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
                                        <input type="text" class="form-control" id="inputEmail4" placeholder="Title" name="fieldOrTopicTitle">
                                        <div id="danger-Title"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert ">

                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="categoryRoot">Root</label>
                                        <select id="categoryRoot" class="form-control" name="fieldSelector">
                                            <option selected>Root</option>
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
                                        <input id="DateCategory" value="<?php echo '20'.date("y-m-d"); ?>" name="DateCategory" class="form-control flatpickr flatpickr-input active" type="text" placeholder="2021-04-12">
                                        <div id="danger-DateCategory"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert ">

                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="DateCategory"> Description </label>
                                       <textarea class="form-control " name="Description"></textarea>
                                        <div id="danger-Description"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert ">

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