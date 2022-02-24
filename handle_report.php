<?php
require_once "./Constants/db_queries.php";
require_once "./Constants/messages.php";
require_once "./functions.php";
require_once "./Database/functions.php";
ob_start();

session_start();

if ($_SESSION['user_role'] != DB_ROLE_OWNER && $_SESSION['user_role'] != DB_ROLE_ADMIN && $_SESSION['user_role'] != DB_ROLE_CC) {
    header("location: main_page.php");
}

$report_msg = "";
if (isset($_POST['check_report'])) {
    if (manipulate(QUERY_CHECK_REPORT, "sssi", [date("Y/m/d H:i:s"), DB_REPORT_CHECKED, $_SESSION['user'], $_POST['rid']]) == 1) {
        $report_msg = SUCCESS_REPORT_CHECKED;
    } else {
        alert("Something is wrong, try again later");
    }
}

$allReports = select(QUERY_GET_ALL_REPORT_RESOURCE, "", []);
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
                    <h3>Course Report Management</h3>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <?php
if (!empty($report_msg)) {
    echo '<div id="success"  class="col-xl-12 col-md-12 col-sm-12 col-12 alert alert-success  " >
            ' . $report_msg . '
        </div>';
}
?>
                        <table id="zero-config" class="table table-hover" style="width:100%">
                            <thead>
                            <tr>

                                <th>#</th>
                                <th>Resourse Name</th>
                                <th>Reported By</th>
                                <th>sent date</th>
                                <th>status</th>
                                <th>checkout date</th>
                                <th>checker</th>
                                <th>creator</th>
                                <th class="no-content"></th>
                            </tr>
                            </thead>
                            <tbody>
<?php
if ($allReports != null) {
    foreach ($allReports as $i => $r) {
        $cdate = "-";
        if ($r[2] != null) {
            $cdate = dateTimeTostr($r[2]);
        }
        $checker = "-";
        if ($r[7] != null) {
            $checker = $r[7];
        }
        $btn = "";
        if ($r[4] == DB_REPORT_CHECKED) {
            $btn = '<button class="btn btn-success mr-4" disabled>checked</button>';
        } else {
            $btn = '<form method="POST">
                <input name="rid" style="display:none;" value="' . $r[0] . '"/>
                <button type="submit" name="check_report" class="btn btn-primary mr-4" >check</button>
            </form>';
        }
        $creator = findCreator($r[8])[0];
        if (strcmp($creator, $_SESSION['user']) == 0 || $_SESSION['user_role'] == DB_ROLE_ADMIN || $_SESSION['user_role'] == DB_ROLE_OWNER) {
            echo '<tr>
                <td>' . ($i + 1) . ' </td>
                <td><a href="course_details.php?resource=' . $r[8] . '">' . $r[9] . '</a></td>
                <td>' . $r[6] . '</td>
                <td>' . dateTimeTostr($r[1]) . '</td>
                <td>' . $r[4] . '</td>
                <td>' . $cdate . '</td>
                <td>' . $checker . '</td>
                <td>' . $creator . '</td>
                <td>
                    ' . $btn . '
                </td>
            </tr>';
        }

    }
}
?>




                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Resourse Name</th>
                                <th>Reported By</th>
                                <th>sent date</th>
                                <th>status</th>
                                <th>checkout date</th>
                                <th>checker</th>
                                <th>creator</th>
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
