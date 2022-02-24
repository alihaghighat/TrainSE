<?php
require_once "Constants/db_queries.php";
require_once "Constants/messages.php";
require_once "functions.php";
require_once "Database/functions.php";
ob_start();

session_start();
if ($_SESSION['user_role'] != DB_ROLE_OWNER && $_SESSION['user_role'] != DB_ROLE_ADMIN && $_SESSION['user_role'] != DB_ROLE_CC) {
    header("location: main_page.php");
}

$resources_num = select(QUERY_GET_RESOURCE_COUNT, "", []);
if ($resources_num != null && sizeof($resources_num[0]) > 0) {
    $resources_num = $resources_num[0][0];
} else {
    $resources_num = 0;
}

$students_num = select(QUERY_GET_STD_COUNT, "s", [DB_ROLE_STD]);
if ($students_num != null && sizeof($students_num[0]) > 0) {
    $students_num = $students_num[0][0];
} else {
    $students_num = 0;
}

$cc_num = select(QUERY_GET_CC_COUNT, "s", [DB_ROLE_CC]);
if ($cc_num != null && sizeof($cc_num[0]) > 0) {
    $cc_num = $cc_num[0][0];
} else {
    $cc_num = 0;
}

$topStudents = select(QUERY_GET_ALL_STUDENTS, "s", [DB_ROLE_STD]);

if (is_array($topStudents)) {
    foreach ($topStudents as $i => $s) {
        $topStudents[$i][] = getSuggestCount(getStdID($s[0]));
        $topStudents[$i][] = getCommentCount($s[0]);
    }
}
function top_std_sort($a, $b)
{
    if ($a[7] > $b[7]) {
        return -1;
    } else if ($a[7] < $b[7]) {
        return 1;
    } else {
        if ($a[8] > $b[8]) {
            return -1;
        } else if ($a[8] < $b[8]) {
            return 1;
        } else {
            return 0;
        }
    }

}
usort($topStudents, "top_std_sort");

$topCC = select(QUERY_GET_ALL_CC, "", []);

if (is_array($topCC)) {
    foreach ($topCC as $i => $cc) {
        $topCC[$i][] = getResourceCount($cc[1]);
    }
}
function top_cc_sort($a, $b)
{
    if ($a[9] > $b[9]) {
        return -1;
    } else if ($a[9] < $b[9]) {
        return 1;
    } else {
        return 0;
    }

}
usort($topCC, "top_cc_sort");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>TrineSE project | courses Report Management </title>

    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/structure.css" rel="stylesheet" type="text/css" class="structure" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link href="assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href=plugins/table/datatable/dt-global_style.css">
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" class="dashboard-analytics" />
    <link href="assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css" class="dashboard-sales" />


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
                <h3>Analytics</h3>
            </div>
        </div>

        <div class="row layout-top-spacing">



            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-five">
                    <div class="widget-content">

                        <div class="header">
                            <div class="header-body">
                                <h6></h6>
<!--                                ToDO:time-->

                            </div>
                            <div class="task-action">
                                <div class="dropdown  custom-dropdown">



                                </div>
                            </div>
                        </div>

                        <div class="w-content">
                            <div class="">
                                <p class="task-left"><?php echo $count_user_online; ?></p>
                                <p class="task-completed"><span></span></p>
                                <p class="task-hight-priority"><span>Users </span> are online</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="row widget-statistic">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="widget widget-one_hybrid widget-followers">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                </div>
                                <p class="w-value"><?php echo custom_number_format($cc_num, 1); ?></p>
                                <h5 class="">cc</h5>
                            </div>
                            <div class="widget-content">
                                <div class="w-chart">
                                    <div id="hybrid_followers"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="widget widget-one_hybrid widget-referral">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                </div>
                                <p class="w-value"><?php echo custom_number_format($students_num, 1); ?></p>
                                <h5 class="">student</h5>
                            </div>
                            <div class="widget-content">
                                <div class="w-chart">
                                    <div id="hybrid_followers1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="widget widget-one_hybrid widget-engagement">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                </div>
                                <p class="w-value"><?php echo custom_number_format($resources_num, 1); ?></p>
                                <h5 class="">Resource</h5>
                            </div>
                            <div class="widget-content">
                                <div class="w-chart">
                                    <div id="hybrid_followers3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-two">

                    <div class="widget-heading">
                        <h5 class="">Top Students</h5>
                    </div>
                    <!--                                TODO:Top Students-->
                    <div class="widget-content">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th><div class="th-content">#</div></th>
                                    <th><div class="th-content">UserName</div></th>
                                    <th><div class="th-content">Name</div></th>
                                    <th><div class="th-content th-heading">LastName</div></th>
                                    <th><div class="th-content">Email</div></th>
                                    <th><div class="th-content">#Suggests</div></th>
                                    <th><div class="th-content">#Comments</div></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
if ($topStudents != null) {

    foreach ($topStudents as $i => $s) {
        echo '<tr>
        <td><div class="td-content customer-name">' . strval($i + 1) . '</div></td>
        <td><div class="td-content product-brand">' . $s[0] . '</div></td>
        <td><div class="td-content">' . $s[1] . '</div></td>
        <td><div class="td-content pricing"><span class="">' . $s[2] . '</span></div></td>
        <td><div class="td-content">' . $s[3] . '</div></td>
        <td><div class="td-content">' . $s[7] . '</div></td>
        <td><div class="td-content">' . $s[8] . '</div></td>
    </tr>';
    }
}
?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-two">

                    <div class="widget-heading">
                        <h5 class="">Top Course Coordinators</h5>
                    </div>

                    <div class="widget-content">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th><div class="th-content">#</div></th>
                                    <th><div class="th-content">UserName</div></th>
                                    <th><div class="th-content">Name</div></th>
                                    <th><div class="th-content th-heading">LastName</div></th>
                                    <th><div class="th-content">Email</div></th>
                                    <th><div class="th-content">#Resources</div></th>
                                </tr>
                                </thead>
                                <tbody>
<!--                                TODO:TOPCC-->
<?php
if ($topStudents != null) {
    foreach ($topCC as $i => $cc) {

        echo '<tr>
        <td><div class="td-content customer-name">' . strval($i + 1) . '</div></td>
        <td><div class="td-content product-brand">' . $cc[1] . '</div></td>
        <td><div class="td-content">' . $cc[3] . '</div></td>
        <td><div class="td-content pricing"><span class="">' . $cc[4] . '</span></div></td>
        <td><div class="td-content">' . $cc[5] . '</div></td>
        <td><div class="td-content">' . $cc[9] . '</div></td>
    </tr>';
    }
}
?>

                                </tbody>
                            </table>
                        </div>
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
<script src="plugins/table/datatable/datatables.js"></script>
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

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
</script>
</body>
</html>
