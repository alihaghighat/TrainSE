<?php
require_once "./Constants/db_queries.php";
require_once "./Constants/messages.php";
require_once "./Database/functions.php";
ob_start();

session_start();

if (!isset($_SESSION['user'])) {
    header("location: login.php");
}

if ($_SESSION['user_role'] != DB_ROLE_OWNER) {
    header("location: home.php");
}

if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    header("location: login.php");
}

$success_msg = "";

if (isset($_POST['add_admin'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if ((manipulate(QUERY_SIGNUP_USER, "ssssss", [$username, $first_name, $last_name, $email, md5($password), DB_ROLE_ADMIN]) == 1)) {
        if (manipulate(QUERY_CREATE_ADMIN, "s", [$username]) == 1) {
            $success_msg = '<div id="alert-success"  class="alert alert-success""><h3>' . SUCCESS_ADMIN_ADDED . '</h3></div>';
        } else {
            echo "Oops! Something went wrong. Please try again later.";

        }
    } else {

        echo "Oops! Something went wrong. Please try again later.";
    }
}

if (isset($_POST['block_admin'])) {
    $username = $_POST['username'];
    manipulate(QUERY_CHANGE_USER_ACCESS, "ss", [DB_ROLE_STD, $username]);
    $success_msg = '<div id="alert-success"  class="alert alert-success">' . $username . SUCCESS_ADMIN_BLOCKED . '</div>';
}

if (isset($_POST['unblock_admin'])) {
    $username = $_POST['username'];
    manipulate(QUERY_CHANGE_USER_ACCESS, "ss", [DB_ROLE_ADMIN, $username]);
    $success_msg = '<div id="alert-success"  class="alert alert-success">' . $username . SUCCESS_ADMIN_UNBLOCKED . '</div>';
}
if (isset($_POST['set_as_admin'])) {

    $username = $_POST['username'];
    manipulate(QUERY_CHANGE_USER_ACCESS, "ss", [DB_ROLE_ADMIN, $username]);
    manipulate(QUERY_CREATE_ADMIN, "s", [$username]);
    $success_msg = '<div id="alert-success"  class="alert alert-success">' . SUCCESS_ADMIN_ADDED . '</div>';
}

$allAdmins = select(QUERY_GET_ALL_ADMIN, "", []);
$allUsers = select(QUERY_GET_ALL_NONADMIN_USERS, "", []);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>TrineSE project | Mange All User</title>

    <link rel="icon" type="image/x-icon" href="./assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="./assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="./assets/css/structure.css" rel="stylesheet" type="text/css" class="structure" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link href="./assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="./plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="./plugins/table/datatable/dt-global_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./CSS/manageAdmin.css">
    <link rel="stylesheet" href="./CSS/AddAdmin.css">


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
                    <h3><button type="button" onclick="showAddUser()" data-toggle="modal" class="btn btn-success float-right ml-5"><i class="fa fa-plus-circle"></i></button>
                        <button type="button" onclick="showUser()" data-toggle="modal" class="btn btn-success float-right ml-5"><i class="fa fa-check-square"></i>
                        </button>Manage All Admin</h3>
                </div>


            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

                <div class="widget-content widget-content-area br-6">
                    <?php if (!empty($success_msg)) {
                        echo $success_msg;
                    }

                    ?>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="zero-config" class="table table-hover" style="width:100%">
                            <thead>
                            <tr>

                                <th>#</th>
                                <th>Name</th>
                                <th>lastName</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="no-content"></th>
                            </tr>
                            </thead>
                            <tbody>





<?php
if ($allAdmins != null) {
    foreach ($allAdmins as $i => $admin) {
        if ($admin[8] != DB_ROLE_OWNER) {
            print("");
            $btn = '<form method="post" name="myform">
                <input type="text" name="username" style="display:none;" value="' . $admin[2] . '"/>
                <button type="submit" name="block_admin" class="btn btnLock mr-4" ><i class="fa fa-lock"></i></button>
            </form>';
            if ($admin[8] == DB_ROLE_STD) {
                $btn = '<form method="post" name="myform">
                    <input type="text" name="username" style="display:none;" value="' . $admin[2] . '"/>
                    <button type="submit" name="unblock_admin" class="btn btnUnLock mr-4" ><i class="fa fa-unlock"></i></button>
                </form>';
            }
            echo '<tr>
                    <td>' . ($i + 1) . '</td>
                    <td>' . $admin[3] . '</td>
                    <td>' . $admin[4] . '</td>
                    <td>' . $admin[2] . '</td>
                    <td>' . $admin[5] . '</td>
                    <td>' . $admin[8] . '</td>

                    <td>' . $btn . '</td>
                </tr>';

        }

    }
}
?>



                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>lastName</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="no-content"></th>
                            </tr>
                            </tfoot>
                        </table>
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

<!-- Add user By Form -->
<div class="modal fade bd-example-modal-xl" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="model-addUser">Add New Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body" id="body-modlae">
                <div class="row register">
                    <div class="col-md-3 register-left">
            <!--            <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>-->
                    </div>
                    <div class="col-md-9 register-right">

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="append" role="tabpanel" aria-labelledby="append-tab">
                                <h3  class="register-heading"><strong>Add New Admin</strong></h3>
                                <form method="POST">
                                <div class="row register-form">
                                    <div class="col-md-6">
                                    <div class="form-outline">
                                            <input type="text" id="Tusername" name="username" placeholder="username" onkeyup="usernameValidation(this)" class="form-control form-control-lg" aria-describedby="validationFeedbackUser" required/>
                                            <div id="validationFeedbackUser" class="invalid-feedback">
                                            <?php echo ERR_USERNAME_TAKEN; ?>
                                            </div>
                                        </div>
                                        <div class="form-outline">
                                            <input type="text" id="Tfirstname" placeholder="FirstName" onkeyup="nameValidation(this)" name="first_name" class="form-control form-control-lg" aria-describedby="validationFeedbackfirstname" required/>
                                            <div id="validationFeedbackfirstname" class="invalid-feedback">
                                            <?php echo ERR_INVALID_NAME; ?>
                                            </div>
                                        </div>
                                        <div class="form-outline">
                                            <input type="text" id="Tlastname" placeholder="LastName" onkeyup="nameValidation(this)" name="last_name" class="form-control form-control-lg" required/>
                                            <div id="validationFeedbacklastname" class="invalid-feedback">
                                                <?php echo ERR_INVALID_NAME; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="form-outline">
                                            <input type="email" id="Temail" placeholder="Email" name="email" onkeyup="emailValidation(this)" class="form-control form-control-lg" aria-describedby="validationFeedbackEmail" required/>
                                            <div id="emailvalidationFeedbackUser" class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="form-outline">
                                            <input type="password" id="Tpassword" placeholder="Password" onkeyup="passwordValidation(this)" name="password" class="form-control form-control-lg" aria-describedby="validationFeedbackPassword" required/>
                                            <div id="validationFeedbackPassword" class="invalid-feedback">
                                            <?php echo ERR_INVALID_PWD; ?>
                                            </div>
                                        </div>
                                        <div class="form-outline">
                                            <input type="password" id="Tconfirm_password" onkeyup="confirmPassValidation(this)" placeholder="confirm_password" name="confirm_password" class="form-control form-control-lg" aria-describedby="validationFeedbackConfirmPassword" required/>
                                            <div id="validationFeedbackConfirmPassword" class="invalid-feedback">
                                            <?php echo ERR_MISMATCH_PWD; ?>
                                            </div>

                                    </div>
                                    <input type="submit" class="btnRegister" name="add_admin"  value="Save"/>

                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> close</button></button>
            </div>
        </div>
    </div>
</div>


<!-- Add user By select From List -->
<div class="modal fade bd-example-modal-xl" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="model-listUser">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body" id="body-modelae">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="table-responsive mb-4 mt-4">
                            <table id="zero-config1" class="table table-hover" style="width:100%">
                                <thead>
                                <tr>

                                    <th>#</th>
                                    <th>Name</th>
                                    <th>lastName</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="no-content"></th>

                                </tr>
                                </thead>
                                <tbody>

                                <?php
if ($allUsers != null) {
    foreach ($allUsers as $i => $user) {
        echo '<tr>
                <td>' . ($i + 1)  . '</td>
                <td>' . $user[1] . '</td>
                <td>' . $user[2] . '</td>
                <td>' . $user[0] . '</td>
                <td>' . $user[3] . '</td>
                <td>' . $user[6] . '</td>

                <td>
                    <form method="post">
                         <input type="text" name="username" style="display:none;" value="' . $user[0] . '"/>
                         <button type="submit" name="set_as_admin" class="btn btnCheck mr-4" ><i class="fa fa-check-circle"></i></button>
                    </form>
                </td>
            </tr>
';
    }
}
?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>lastName</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="no-content"></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> close</button>
            </div>
        </div>
    </div>
</div>




<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="./bootstrap/js/popper.min.js"></script>
<script src="./bootstrap/js/bootstrap.min.js"></script>
<script src="./plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="./assets/js/app.js"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="./assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="./plugins/apex/apexcharts.min.js"></script>
<script src="./assets/js/dashboard/dash_1.js"></script>
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="./plugins/table/datatable/datatables.js"></script>
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
    $('#zero-config1').DataTable({
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
    function showUser(){
        $('#exampleModal').modal('show');
    }
    function showAddUser(){
        $('#exampleModal1').modal('show');

    }
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
