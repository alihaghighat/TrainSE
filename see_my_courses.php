<?php
session_start();

ob_start();

require_once "Database/functions.php";
require_once "Constants/db_queries.php";
require_once "functions.php";

//Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["user"])) {
    header("location: login.php");
    exit;
}

if ($_SESSION['user_role'] != DB_ROLE_OWNER && $_SESSION['user_role'] != DB_ROLE_ADMIN && $_SESSION['user_role'] != DB_ROLE_CC) {
    header("location: index.php");
    exit;
}

if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    header("location: login.php");
}

//$selected_topics = [];

$resource_creator_username = $_SESSION["user"];

$all_topics = select(QUERY_ALL_TOPICS, "", []);

function fetch_my_resources()
{
    $fetched_resources = select(QUERY_FETCH_MY_RESOURCES, "", []);
    //print_r($fetched_resources);

    //$resources_length = count($fetched_resources);

    if (is_array($fetched_resources)) {

        for ($i = 0; $i < count($fetched_resources) - 1; $i++) {
            $first_index = $fetched_resources[$i][0];
            $second_index = $fetched_resources[$i][1];
            $third_index = $fetched_resources[$i][2];
            $fourth_index = $fetched_resources[$i][3];
            $fifth_index = $fetched_resources[$i][4];
            $sixth_index = $fetched_resources[$i][5];
            $seventh_index = $fetched_resources[$i][6];
            $eighth_index = $fetched_resources[$i][7];
            for ($j = $i + 1; $j < count($fetched_resources); $j++) {
                if ($fetched_resources[$j][0] == $first_index && $fetched_resources[$j][1] == $second_index && $fetched_resources[$j][2] == $third_index && $fetched_resources[$j][3] == $fourth_index && $fetched_resources[$j][4] == $fifth_index && $fetched_resources[$j][5] == $sixth_index && $fetched_resources[$j][6] == $seventh_index && $fetched_resources[$j][7] == $eighth_index) {
                    if ((strlen($fetched_resources[$i][8]) + strlen($fetched_resources[$j][8])) <= 19) {
                        $fetched_resources[$i][8] .= "," . $fetched_resources[$j][8];
                    } else {
                        $fetched_resources[$i][8] .= "...";
                    }
                    array_splice($fetched_resources, $j, 1);
                    $j--;
                    //print_r($fetched_resources);
                    //$resources_length--;

                }
            }
        }
    }

    return $fetched_resources;
}

$my_resources = fetch_my_resources();
//print_r($my_resources);

$row_number = 1;

if (isset($_POST["add-resource-btn"])) {

    $selected_topics = $_POST["topicSelector"];
    //print_r($selected_topics);
    $resource_title = $_POST['CourseTitle'];
    $resource_date = $_POST['CourseDate'];
    $resource_link = $_POST['CourseLink'];
    $resource_description = $_POST['CourseDescription'];
    $resource_duration = $_POST['CourseDuration'];
    $resource_date = $_POST['CourseDate'];
    $imgName = "field_topic_default.png";
    $tags = getTags($_POST['CourseTag']);

    //print_r($selected_topics);

    if (!empty($_FILES["CourseImage"]["name"])) {

        $imgName = generateRandomString() . "_" . $_SESSION['user'] . "_";
        $imgName .= basename($_FILES["CourseImage"]["name"]);

        $target_dir = "uploads/";
        $target_file = $target_dir . $imgName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image

        $check = getimagesize($_FILES["CourseImage"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

// Check file size
        if ($_FILES["CourseImage"]["size"] > 40000000) {
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
            if (move_uploaded_file($_FILES["CourseImage"]["tmp_name"], $target_file)) {
//$imgName = basename($_FILES["CourseImage"]["name"]);
                echo "The file " . htmlspecialchars(basename($_FILES["CourseImage"]["name"])) . " has been uploaded.";

            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

    }

    if (manipulate(QUERY_ADD_RESOURCE_CREATOR, "s", [$resource_creator_username]) === 1) {
//echo "new resource creator added ";
    }

    $resource_creator_id = select(QUERY_GET_CREATOR_ID_BY_USERNAME, "s", [$resource_creator_username]);
//echo ($resource_creator_id[0][0]);

    if (manipulate(QUERY_ADD_NEW_RESOURCE, "ssssisi", [$resource_title, $resource_description, $resource_link, $imgName, intval($resource_duration), $resource_date, $resource_creator_id[0][0]]) === 1) {
//echo "new resource added!";
    }

    $topic_IDs = [];
    if (is_array($selected_topics) || is_object($selected_topics)) {
        foreach ($selected_topics as $selected_topic) {
//echo($selected_topic);
            array_push($topic_IDs, select(QUERY_GET_TOPIC_ID_BY_TITLE, "s", [$selected_topic])[0]);
        }
    }

//print_r($topic_IDs);

    $resource_resourceID = select(QUERY_GET_RESOURCE_ID_BY_CREATOR_ID, "i", [intval($resource_creator_id[0][0])]);

//print_r($resource_resourceID);
    foreach ($tags as $tag) {
        $res = select(QUERY_GET_SAME_TAGS, "s", [$tag]);
        if (!is_array($res) or !(sizeof($res) > 0)) {
            if (manipulate(QUERY_ADD_TAG, "s", [$tag]) == 1) {
            }
            $res = select(QUERY_GET_SAME_TAGS, "s", [$tag]);
        }
        manipulate(QUERY_SET_RESOURCE_TAG, "ii", [$res[0][0], (int) $resource_resourceID[count($resource_resourceID) - 1][0]]);
    }
    foreach ($topic_IDs as $topic_ID) {
        if (manipulate(QUERY_ADD_NEW_TOPIC_RESOURCE, "ii", [(int) $topic_ID[0], (int) $resource_resourceID[count($resource_resourceID) - 1][0]]) === 1) {
//echo "new topic_resource added!";
        }

    }

    $my_resources = fetch_my_resources();

}

if (isset($_POST['del_example'])) {
    if (manipulate(QUERY_DELETE_EXAMPLE_BY_ID, "i", [intval($_POST['del_example_id'])]) == 1) {
        echo "example deleted successfully";
    }

}

?>












<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>TrineSE project | See My Course</title>

    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/structure.css" rel="stylesheet" type="text/css" class="structure" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link href="assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

    <link rel="stylesheet" href="CSS/SeeMyCourse.css">
    <link rel="stylesheet" href="CSS/AddCourse.css">
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
                    <h3><button onclick="SeeMyCourse()" class="btn btn-warning float-right ml-5"><i class="fa fa-plus-circle"></i></button>
                        See My Course</h3>


                </div>

                <!-- TODO Show Course Title-->
                <!-- <h3  class="msgP alert-success float-right">Python Course Added </h3> -->

            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

                <div class="widget-content widget-content-area br-6">

                    <div class="table-responsive mb-4 mt-4">
                        <table id="zero-config" class="table table-hover" style="width:100%">
                            <thead>
                            <tr>

                                <th>#</th>
                                <th>Title</th>
                                <th>Topic</th>
                                <th>Duration</th>
                                <th>Date</th>
<!--                                <th>Time</th>-->
                                <th class="no-content"></th>
                            </tr>
                            </thead>
                            <tbody>

                             <?php
if (is_array($my_resources) || is_object($my_resources)) {
    foreach ($my_resources as $my_resource) {
        if (strcmp(findCreator($my_resource[0])[0], $_SESSION['user']) == 0 || $_SESSION['user_role'] == DB_ROLE_ADMIN || $_SESSION['user_role'] == DB_ROLE_OWNER) {
            echo '<tr>
                                <td>' . $row_number . ' </td>
                                <td>' . $my_resource[1] . ' </td>
                                <td>' . $my_resource[8] . '</td>
                                <td>' . convertToHoursMins($my_resource[5]) . '</td>
                                <td>' . dateTostr($my_resource[6]) . '</td>
<!--                                <td>21:10</td>-->
                                <td>
                                    <!-- TODO: LINK TO Relative Page-->
                                    <a href="course_details.php?resource=' . $my_resource[0] . '" class="btn btn-success m-2" ><i class="fa fa-eye"></i></a>
                                    <!-- TODO: if Course Add To Bookmark, Remove BookMark Button-->
                                <button onclick="AddExample(' . $my_resource[0] . ')" class="btn btn-warning m-2 " ><i class="fa fa-folder-open"></i></button>
                                    <!-- TODO: if Delete Button Click, Remove Course-->
<!--                                    <button class="btn btnDelete" ><i class="fa fa-trash"></i></button>-->
                                </td>
                            </tr>';
            $row_number++;
        }
    }
}
?>


                            </tbody>
                            <tfoot>
                            <tr>

                                <th>#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Duration</th>
                                <th>Date</th>
<!--                                <th>Time</th>-->
                                <th class="no-content"></th>
                            </tr>
                            </tfoot>
                        </table>
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
<div class="modal fade bd-example-modal-xl" id="AddExample" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="model-addUser">Add Example</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body" id="body-AddExample">

            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal"><i class="flaticon-cancel-12"></i> close</button>

            </div>
        </div>

    </div>

</div>

    <!-- Add Course By Form -->
    <div class="modal fade bd-example-modal-xl" id="AddCourseModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="model-addUser">Add New Course</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <div class="modal-body" id="body-modlae">
                    <div class="row register">
                        <div class="col-md-1 register-left">

                        </div>
                        <div class="col-md-11 register-right">

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="append" role="tabpanel" aria-labelledby="append-tab">
                                    <h3  class="register-heading text-info font-weight-bolder">Add New Course</h3>
                                    <form method="post" enctype="multipart/form-data">
                                    <div class="row register-form">
                                        <div class="col-md-6">
                                            <div class="form-outline">
                                                <input type="text" id="Title" name="CourseTitle" placeholder="Title" class="form-control form-control-lg " aria-describedby="validationFeedbackTitle" required/>
                                                <div id="validationFeedbackTitle" class="valid-feedback">
                                                    <!-- TODO Error Message-->
                                                </div>
                                            </div>

                                            <div class="form-outline">
                                                <div class="form-outline">
                                                    <input type="Date" id="Date" placeholder="Date" name="CourseDate" class="form-control form-control-lg " required/>
                                                </div>

                                                <div class="form-outline">
                                                    <div class="custom-file-container" data-upload-id="myImage">
                                                        <label>Upload  <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                                        <label class="custom-file-container__custom-file" >
                                                            <input type="file" id="Image" placeholder="Image" name="CourseImage" class="custom-file-container__custom-file__custom-file-input" accept="image/*">
                                                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                                                        </label>
                                                        <div class="custom-file-container__image-preview"></div>
                                                    </div>
                                                    <div id="validationFeedbackImage" class="valid-feedback">
                                                        <!-- TODO Error Message-->
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-outline">
                                                <div class="form-outline">
                                                    <input type="text" id="Link"  name="CourseLink" placeholder="Link" class="form-control form-control-lg " aria-describedby="validationFeedbackLink" required/>
                                                    <div id="validationFeedbackLink" class="valid-feedback">
                                                        <!-- TODO Error Message-->
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-outline">

                                                <textarea name="CourseDescription" placeholder="Description" class="form-control form-control-lg " aria-describedby="validationFeedbackDescription" required></textarea>
                                                <div id="validationFeedbackDescription" class="valid-feedback">
                                                    <!-- TODO Error Message-->
                                                </div>
                                            </div>

                                            <div class="form-outline">
                                                <input type="text" id="Duration" placeholder="Duration" name="CourseDuration" class="form-control form-control-" aria-describedby="validationFeedbackDuration" required/>
                                                <div id="validationFeedbackDuration" class="valid-feedback">
                                                    <!-- TODO Error Message-->
                                                </div>
                                            </div>
                                            <div class="form-outline">

                                                <textarea name="CourseTag" placeholder="#tag1 #tag_2" class="form-control form-control-lg " aria-describedby="validationFeedbackDescription" required></textarea>
                                                <div id="validationFeedbackTag" class="valid-feedback">
                                                    <!-- TODO Error Message-->
                                                </div>
                                            </div>


                                            <!--TODO:TOPIC MULTI SELECTION-->
                                            <h6 class="p-1 font-weight-bolder">Choose Related Topic</h6>
                                            <select class="selectPicker m-1 btn-outline-info" multiple data-live-search="true" name="topicSelector[]">
                                                <?php
foreach ($all_topics as $topic) {
    echo '<option>' . $topic[0] . '</option>';
}
?>
                                            </select>

                                            <input type="submit" class="btnRegister mt-5"  value="Save" name="add-resource-btn" />
                                            </form>


                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal"><i class="flaticon-cancel-12"></i> close</button>

                </div>
            </div>
        </div>
    </div>


</div>
<!-- END MAIN CONTAINER -->




<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="assets/js/app.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script>
    $('select').selectpicker();
</script>

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
<script src="plugins/table/datatable/datatables.js"></script>
<script>
    $('#zero-config').DataTable({
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7
    });

    function SeeMyCourse(){
        $('#AddCourseModel').modal('show');

    }
    function SubmitAddExample(id){
        var TitleExample=$('#TitleExample').val();
        var LinkExample=$('#LinkExample').val();
        $("#alert-danger-addExample").hide();
        if(TitleExample!='' && LinkExample!=''){
            $.ajax({

                url:'viewmodel/add_example_function.php',

                data:{
                    "courseId":id,
                    "TitleExample":TitleExample,
                    "LinkExample":LinkExample
                },

                type:'post',

                success: function(data){
                    $("#alert-success-addExample").show();
                    $("#alert-success-addExample").html(data);
                    setTimeout(function () {
                        $("#alert-success-addExample").hide();
                        location.reload();
                    },2000)
                }

            })
        }else{
            $("#alert-danger-addExample").show();
            $("#alert-danger-addExample").html("Fill in the required items");
            setTimeout(function () {
                $("#alert-danger-addExample").hide();
            },5000)
        }


    }
    function AddExample(id){
        $('#AddExample').modal('show');
        $("#body-AddExample").html("");
        $.ajax({

            url:'viewmodel/add_example.php',

            data:{
                "courseId":id
            },

            type:'post',

            success: function(data){

                $("#body-AddExample").html(data);
            }

        })

    }


    function delete_example_submit(id) {
    $.ajax({

                url:'viewmodel/del_example_function.php',

                data:{
                    "exampleId":id,
                },

                type:'post',

                success: function(data){
                    $("#alert-success-addExample").show();
                    $("#alert-success-addExample").html(data);
                    setTimeout(function () {
                        $("#alert-success-addExample").hide();
                        location.reload();
                    },2000)

                }

            })
   }



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
        var firstUpload = new FileUploadWithPreview('myImage')

    </script>

<script>
    $("h3").click(function(){
        $(".msgP").fadeOut();
    });
</script>




</body>
</html>