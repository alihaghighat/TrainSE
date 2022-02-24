<?php
session_start();

ob_start();

require_once "Database/functions.php";
require_once "Constants/db_queries.php";
require_once "Constants/db_names.php";
require_once "Database/functions.php";
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
if (isset($_POST['check_suggest'])) {
    manipulate(QUERY_CHECK_RESOURCE_SUGGEST, "ssi", [DB_SUGGEST_CHECKED, getCCID($_SESSION['user']), $_POST['suggest_id']]);
}

$allSuggests = select(QUERY_GET_ALL_RESOURCE_SUGGEST, "", []);
$all_topics = select(QUERY_ALL_TOPICS, "", []);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>TrineSE project | Handle Suggest Resource</title>

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
                    Handle Suggest Resource</h3>

            </div>



        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

            <div class="widget-content widget-content-area br-6">

                <div class="table-responsive mb-4 mt-4">
                    <table id="zero-config" class="table table-hover" style="width:100%">
                        <thead>
                        <tr>

                            <th>#</th>
                            <th>Link</th>
                            <th>Description</th>
                            <th>Student</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
if ($allSuggests != null) {
    foreach ($allSuggests as $i => $s) {
        $btn = "";
        if ($s[6] == DB_SUGGEST_CHECKED) {
            $btn = '<button type="button" class="btn btn-success" disabled>Checked</button>';
        } else {
            $btn = '<form method="POST">
                        <input class="btn btn-primary" type="submit" name="check_suggest" value="Check">
                        <input value="' . $s[0] . '" style="display:none" name="suggest_id" >
                    </form>';
        }
        $tempvaiblae = "'#LinkId-$s[0]'";
        $tempvaiblae1 = "'span-LinkId-$s[0]'";

        echo '  <tr>
        <td>1 </td>
        <td><a target="_blank" href="' . $s[4] . '" class="btn btnVisit btn-sm" ><i class="fa fa-eye"></i></a> </td>
        <td>' . $s[5] . '</td>
        <!--                            TODO: change ID of LinkId-1 foreach row   -->
        <td id="LinkId-' . $s[0] . '" style="display: none">
        ' . $s[4] . '
        </td>
        <td>' . getSTDUsername($s[2]) . '</td>
        <td>' . dateTimeTostr($s[1]) . '</td>
        <td>' . $btn . '</td>
        <td id="span-LinkId-' . $s[0] . '">

            <button class="btn btn-warning" onclick="copyToClipboard(' . $tempvaiblae . ',' . $tempvaiblae1 . ')"> <i class="fa fa-save"></i></button>
        </td>

    </tr>';
    }
}
?>


                        </tbody>
                        <tfoot>
                        <tr>

                            <th>#</th>
                            <th>Link</th>
                            <th>Description</th>
                            <th>Student</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th></th>

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
                                <form method="post" action="see_my_courses.php" enctype="multipart/form-data">
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
    function copyToClipboard(element,idSpan) {

        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();

        $("#Link").val($(element).text().replace(/\s/g, ''));
        document.execCommand("copy");
        $temp.remove();
        document.getElementById(idSpan).innerHTML = "Copy link";

        setTimeout(function () {
            document.getElementById(idSpan).innerHTML = '<button class="btn btn-warning" onclick="copyToClipboard('+element+','+idSpan+')"> <i class="fa fa-save"></i></button>';
        },5000)
    }

</script>




</body>
</html>