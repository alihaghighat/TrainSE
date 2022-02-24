<?php
ob_start();

session_start();

require_once "Database/functions.php";
require_once "Constants/db_queries.php";
require_once "Database/functions.php";
require_once "./Constants/messages.php";
require_once "functions.php";

//Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["user"])) {
    header("location: login.php");
    exit;
}

// if ($_SESSION['user_role'] != DB_ROLE_OWNER && $_SESSION['user_role'] != DB_ROLE_ADMIN && $_SESSION['user_role'] != DB_ROLE_CC) {
//     header("location: index.php");
//     exit;
// }

if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    header("location: login.php");
}

//$selected_topics = [];

//$resource_creator_username = $_SESSION["user"];

$all_topics = select(QUERY_ALL_TOPICS, "", []);

$rid = -1;
if (isset($_GET['resource'])) {
    $rid = $_GET['resource'];
} else if (isset($_POST['resource'])) {
    $rid = $_POST['resource'];
} else {
    alert(ERR_RESOURCE_NOT_GIVEN);
}

$resource_topics = [];

//function fetch_resource_details()
//{
$resource_details = select(QUERY_FETCH_RESOURCE_ATTRS, "i", [$rid]);

for ($i = 0; $i < count($resource_details); $i++) {
    array_push($resource_topics, $resource_details[$i][8]);
}

//print_r($resource_topics);

//print_r($fetched_resources);

//$resources_length = count($fetched_resources);

// for($i=0; $i<count($fetched_resources)-1; $i++){
//     $first_index = $fetched_resources[$i][0];
//     $second_index = $fetched_resources[$i][1];
//     $third_index = $fetched_resources[$i][2];
//     $fourth_index = $fetched_resources[$i][3];
//     $fifth_index = $fetched_resources[$i][4];
//     $sixth_index = $fetched_resources[$i][5];
//     $seventh_index = $fetched_resources[$i][6];
//     $eighth_index = $fetched_resources[$i][7];
//     for($j=$i+1; $j<count($fetched_resources); $j++){
//         if($fetched_resources[$j][0] == $first_index && $fetched_resources[$j][1] == $second_index && $fetched_resources[$j][2] == $third_index && $fetched_resources[$j][3] == $fourth_index && $fetched_resources[$j][4] == $fifth_index && $fetched_resources[$j][5] == $sixth_index && $fetched_resources[$j][6] == $seventh_index && $fetched_resources[$j][7] == $eighth_index){
//             echo "here";
//             if( (strlen($fetched_resources[$i][8])+strlen($fetched_resources[$j][8])) <= 19 ){
//             $fetched_resources[$i][8] .= ",".$fetched_resources[$j][8];
//         }else{
//             $fetched_resources[$i][8] .= "...";
//         }
//             array_splice($fetched_resources, $j, 1);
//             $j--;
//             //print_r($fetched_resources);
//             //$resources_length--;

//         }
//         }
// }

//return $resource_details;
//}

//$resource_details = fetch_resource_details();

$resource_title = $resource_details[0][1];
$resource_description = $resource_details[0][2];
$resource_link = $resource_details[0][3];
$edited_resource_imgName = $resource_details[0][4];
$resource_duration = $resource_details[0][5];
$resource_date = substr($resource_details[0][6], 0, 10);
$resource_duration = $resource_details[0][5];
$resource_tags = select(QUERY_GET_RESOURCE_TAGS, "i", [(int) $rid]);
print_r($resource_tags);
//print_r($resource_details);

// $row_number = 1;

if (isset($_POST["edit-resource-btn"])) {

    $selected_topics = $_POST["editTopicSelector"];
    //print_r($selected_topics);
    $edited_resource_title = $_POST['Title'];
    $edited_resource_description = $_POST['Description'];
    $edited_resource_link = $_POST['Link'];
    $edited_resource_duration = $_POST['Duration'];
    $edited_resource_date = $_POST['DateCategory'];
    $tags = getTags($_POST['CourseTag']);

    //print_r($selected_topics);
    manipulate(QUERY_DELETE_RESOURCE_TAGS, "i", [$rid]);
    foreach ($tags as $tag) {
        $res = select(QUERY_GET_SAME_TAGS, "s", [$tag]);
        if (!is_array($res) or !(sizeof($res) > 0)) {
            if (manipulate(QUERY_ADD_TAG, "s", [$tag]) == 1) {
            }
            $res = select(QUERY_GET_SAME_TAGS, "s", [$tag]);
        }
        manipulate(QUERY_SET_RESOURCE_TAG, "ii", [$res[0][0], (int) $rid]);
    }

    if (!empty($_FILES["EditCourseImage"]["name"])) {

        $edited_resource_imgName = generateRandomString() . "_" . $_SESSION['user'] . "_";
        $edited_resource_imgName .= basename($_FILES["EditCourseImage"]["name"]);

        $target_dir = "uploads/";
        $target_file = $target_dir . $edited_resource_imgName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image

        $check = getimagesize($_FILES["EditCourseImage"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

// Check file size
        if ($_FILES["EditCourseImage"]["size"] > 40000000) {
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
            if (move_uploaded_file($_FILES["EditCourseImage"]["tmp_name"], $target_file)) {
                $edited_resource_imgName = basename($_FILES["EditCourseImage"]["name"]);
                echo "The file " . htmlspecialchars(basename($_FILES["EditCourseImage"]["name"])) . " has been uploaded.";

            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

    }

    if (manipulate(QUERY_EDIT_RESOURCE, "ssssisi", [$edited_resource_title, $edited_resource_description, $edited_resource_link, $edited_resource_imgName, $edited_resource_duration, $edited_resource_date, 1]) === 1) {
        //echo "new resource creator added ";
    }

    if (manipulate(QUERY_DELETE_RESOURCE_TOPIC, "i", [1]) === 1) {
        //echo "new resource creator added ";
    }

    $selected_topic_IDs = [];
    for ($i = 0; $i < count($selected_topics); $i++) {
        array_push($selected_topic_IDs, select(QUERY_GET_TOPIC_ID_BY_TITLE, "s", [$selected_topics[$i]])[0][0]);
    }

    for ($i = 0; $i < count($selected_topic_IDs); $i++) {
        if (manipulate(QUERY_ADD_NEW_TOPIC_RESOURCE, "ii", [$selected_topic_IDs[$i], 1]) === 1) {
            //echo "new resource creator added ";
        }
    }

    header('location: course_details.php?resource=' . $rid);

}

?>










<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>TrineSE project | EditResource</title>

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

    <link href="assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="plugins/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
</head>
<body class="dashboard-analytics">
<?php include "./validation.php";?>


<?php
require_once "dashboard_menu.php";
?>

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="page-header">
                <div class="page-title">
                    <h3>Edit resource</h3>
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
                            <div id="success"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert alert-success  " style="display: none;">

                            </div>

                            <!-- TODO: EditCourse Form-->
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-row mb-4">
                                    <div class="form-group col-md-6">
                                        <label for="Title">Title</label>
                                        <input type="text" value="<?php echo ($resource_title); ?>" name="Title" class="form-control" id="Title" placeholder="Title">
                                        <div id="danger-Title"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert ">

                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Description">Description</label>
                                        <textarea name="Description" class="form-control" id="Description" placeholder="Description"><?php echo ($resource_description); ?></textarea>

                                        <div id="danger-Description"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert ">

                                        </div>
                                    </div>
                                </div>

                                <div class="form-row mb-4">
                                    <div class="form-group col-md-6">
                                        <label for="Link">Link</label>
                                        <input type="text" value="<?php echo ($resource_link); ?>" name="Link" class="form-control" id="Link" placeholder="Link">
                                        <div id="danger-Link"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert ">

                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="Topic">Add Related Topic</label>
                                        <select id="multiple" class="form-control nested" multiple="multiple" name="editTopicSelector[]">
                                            <?php foreach ($resource_topics as $resource_topic) {
    echo '<option selected>' . $resource_topic . '</option>';
}
foreach ($all_topics as $topic) {
    echo '<option>' . $topic[0] . '</option>';
}
?>
                                        </select>
                                        <div id="danger-Topic"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert ">

                                        </div>
                                    </div>
                                </div>

                                <div class="form-row mb-4">
                                    <div class="form-group col-md-6">
                                        <label for="DateCategory"> Date </label>
                                        <input id="DateCategory" value="<?php echo ($resource_date); ?>" name="DateCategory" class="form-control flatpickr flatpickr-input active" type="text" placeholder="2021-04-12">
                                        <div id="danger-DateCategory"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert ">

                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="Duration">Duration</label>
                                        <input type="text" value="<?php echo ($resource_duration); ?>" name="Duration" class="form-control" id="Duration" placeholder="Duration">
                                        <div id="danger-Duration"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert ">

                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <div class="custom-file-container" data-upload-id="myFirstImage">
                                            <label>Upload category Icon <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                            <label class="custom-file-container__custom-file" >
                                                <input type="file" name="EditCourseImage" class="custom-file-container__custom-file__custom-file-input" accept="image/*">
                                                <input type="hidden" name="EditCourse" value="10485760" />
                                                <span class="custom-file-container__custom-file__custom-file-control"></span>
                                            </label>
                                            <div class="custom-file-container__image-preview"></div>
                                        </div>
                                        <div id="danger-categoryIcon"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert ">

                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Description">Tags</label>
                                        <textarea name="CourseTag" class="form-control" id="CourseTag" placeholder="Tags"><?php

if (is_array($resource_tags)) {
    foreach ($resource_tags as $t) {
        echo "#" . $t[2] . "\n";
    }
}

?></textarea>

                                        <div id="danger-CourseTag"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert ">

                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mt-3" name="edit-resource-btn">submit</button>

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
<script src="assets/js/scrollspyNav.js"></script>
<script src="plugins/select2/select2.min.js"></script>
<script src="plugins/select2/custom-select2.js"></script>
<script>
    $(".nested").select2({
        tags: true
    });
</script>
<?php if (!empty($success_msg)) {

    echo "
    <script>
setTimeout(function (){
    $('#alert-success').hide()

},5000)
</script>
    ";

}

?>
</body>
</html>