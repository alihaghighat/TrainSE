<?php
session_start();

ob_start();

require_once "Database/functions.php";
require_once "Constants/db_queries.php";
require_once "Database/functions.php";
require_once "functions.php";

//Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["user"])) {
    header("location: main_page.php");
    exit;
}

if ($_SESSION['user_role'] != DB_ROLE_OWNER && $_SESSION['user_role'] != DB_ROLE_ADMIN) {
    header("location: main_page.php");
    exit;
}

if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    header("location: login.php");
}


if (isset($_GET['suggestID'])) {
    $checker_id = select(QUERY_GET_ADMIN_ID_BY_USERNAME,"s",[$_SESSION["user"]])[0][0];
    if(manipulate(QUERY_CHECK_TOPIC_SUGGEST,"sii",["checked",intval($checker_id),intval($_GET['suggestID'])])){
        header("location: Suggested_field_or_topic.php");
    }
    
}

if (isset($_GET['topicSuggestID'])) {
    $checker_id = select(QUERY_GET_ADMIN_ID_BY_USERNAME,"s",[$_SESSION["user"]])[0][0];
    if(manipulate(QUERY_CHECK_TOPIC_SUGGEST,"sii",["checked",intval($checker_id),intval($_GET['topicSuggestID'])])){
        header("location: add_field_or_topic.php?topicSuggestID=".$_GET['topicSuggestID']);
    }
    
}




$all_suggested_topics = select(QUERY_ALL_SUGGESTED_TOPICS, "", []);


$row_number = 1;



?>












<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>TrineSE project | Suggested Topics</title>

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
                <h3>
                    Suggested Topics</h3>

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
                            <th>Topic</th>
                            <th>Field</th>
                            <th>Date</th>
                            <th>CC Name</th>
                            <th>Status</th>
                            <!--                                <th>Time</th>-->
                            <th class="no-content"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <!--                                ToDo:show Suggested Category-->

                            <?php
                            if(is_array($all_suggested_topics))
                            foreach ($all_suggested_topics as $all_suggested_topic) {

                                $CC_firstName = select(QUERY_GET_CC_NAME_BY_ID,"i", [$all_suggested_topic[3]])[0][0];
                                $CC_lastName = select(QUERY_GET_CC_NAME_BY_ID,"i", [$all_suggested_topic[3]])[0][1];
                                if($all_suggested_topic[6]!='unchecked'){
                                    $suggested_topic_status='<img width="32" src="https://img.icons8.com/color/50/000000/checked-checkbox.png"/>';
                                }else{
                                    $suggested_topic_status='<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 32 32">
  <g id="noun-alert-1272487" transform="translate(-277.199 -207.198)">
    <path id="Path_1" data-name="Path 1" d="M293.2,239.2a16,16,0,1,1,16-16A16,16,0,0,1,293.2,239.2Zm-1.846-22.143v7.979a1.24,1.24,0,0,0,1.229,1.241h1.233a1.231,1.231,0,0,0,1.229-1.241v-7.979a1.24,1.24,0,0,0-1.229-1.241h-1.233A1.232,1.232,0,0,0,291.353,217.055Zm0,12.3v1.233a1.225,1.225,0,0,0,1.229,1.229h1.233a1.225,1.225,0,0,0,1.229-1.229v-1.233a1.226,1.226,0,0,0-1.229-1.23h-1.233A1.226,1.226,0,0,0,291.353,229.352Z" fill="#e2a03f" fill-rule="evenodd"/>
  </g>
</svg>';

                                }
                            echo'
                            <tr>

                                <td>' . $row_number++ . '</td>
                                <td>' . $all_suggested_topic[4] . '</td>
                                <td>' . $all_suggested_topic[5] . '</td>
                                <td>' . substr($all_suggested_topic[1],0,10) . '</td>
                                <td>' . $CC_firstName. " ". $CC_lastName . '</td>
                                <td>' .$suggested_topic_status . '</td>

                                <td class="no-content">
<!--                                    ToDo:add to category-->
                                    <a href="add_field_or_topic.php?topicSuggestID='.$all_suggested_topic[0].'" class="btn btn-warning mr-4" ><i class="fa fa-address-book"></i></a>';

                                    if($all_suggested_topic[6]!='unchecked')
                                        echo '
                                    <a href="Suggested_field_or_topic.php?suggestID='.$all_suggested_topic[0].'" name="check_suggest_btn" class="btn btn-danger mr-4" ><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>';
                        }
                        ?>




                        </tbody>
                        <tfoot>
                        <tr>

                            <th>#</th>
                            <th>Topic</th>
                            <th>Field</th>
                            <th>Date</th>
                            <th>CC Name</th>
                            <th>Status</th>
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


<!-- Add Course By Form -->
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
</script>




</body>
</html>