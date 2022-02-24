<?php

if (isset($_SESSION['user'])) {
    $_SESSION['user_role'] = getRole($_SESSION['user']);
}

if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    unset($_SESSION['role']);
}

include "get_online_users.php";

$userImg = "uploads/default.png";
$user = null;
if (isset($_SESSION['user'])) {
    $user = select(QUERY_FETCH_USER_ATTRS_BY_USERNAME, "s", [$_SESSION['user']])[0];
    if (!empty($user[5])) {
        $userImg = "uploads/" . $user[5];
    }

}
$allFields = select(QUERY_GET_ALL_FIELDS, "", []);

?>



 <div class="preloader">
        <img class="preloader__image" width="60" src="assetsMainPage/images/loader.png" alt="" />
    </div>


 <!-- /.preloader -->
    <div class="page-wrapper">

        <header class="main-header main-header--one  clearfix">
            <!-- <div class="main-header--one__top clearfix">
                <div class="container">
                    <div class="main-header--one__top-inner clearfix">
                        <div class="main-header--one__top-left">
                            <div class="main-header--one__top-logo">
                                <a href="../"><img src="assetsMainPage/images/resources/logo-1.png" alt="" /></a>
                            </div>
                        </div>


                    </div>
                </div>
            </div> -->


            <div class="main-header-one__bottom clearfix">
                <div class="container">
                    <div class="main-header-one__bottom-inner clearfix">
                        <nav class="main-menu main-menu--1">
                            <div class="main-menu__inner">
                                <a href="#" class="mobile-nav__toggler"><i class="fa fa-bars"></i></a>

                                <div class="left">
                                    <ul class="main-menu__list">
                                        <li><a href="main_page.php">Home</a></li>
                                        <li class="dropdown  ">
                                            <a href="#Category">Category</a>
                                            <ul>
                                                <?php
foreach ($allFields as $f) {
    $topic = fetch_topics($f[0]);
    if ($topic == null) {
        echo '<li><a href="courses.php?field=' . $f[0] . '">' . $f[2] . '</a></li>';
    } else {
        echo '<li class="dropdown">
                <a href="courses.php?field=' . $f[0] . '">' . $f[2] . '</a>
                <ul>';
        foreach ($topic as $t) {
            echo '<li><a href="courses.php?topic=' . $t[0] . '">' . $t[3] . '</a></li>';
        }
        echo '</ul>
        </li>';

    }
}

?>
                                            </ul>
                                        </li>
                                        <?php
if (isset($_SESSION['user']) && $_SESSION['user_role'] != DB_ROLE_STD) {
    echo '<li><a href="home.php">Management</a></li>
        <li><a href="my_bookmarks.php" >My bookmarks</a></li>';
}

?>
                                        <?php
if (isset($_SESSION['user']) and $_SESSION['user_role'] == DB_ROLE_STD) {

    echo '<li><a onclick="SuggestResource()">Suggest Resource</a></li>
        <li><a href="my_bookmarks.php" >My bookmarks</a></li>
';

}
?>


                                    </ul>
                                </div>

                                <div class="right">
                                    <div class="main-menu__right">
                                        <div class="main-menu__right-login-register">
                                            <?php
if (isset($_SESSION['user'])) {

    echo '<ul class="list-unstyled">
    <li><a href="#"><img src="' . $userImg . '" style="height: 35px; border-radius: 70%;" alt=""></a></li>
    <li><a href="edit_user_profile.php">' . $user[0] . '</a></li>
    <li><form method="post" ><a href="#"><button type="submit" name="logout" style="border:none;background:none;">logout</button></a></form></li>
</ul>';

} else {
    echo '<ul class="list-unstyled">
<li><a href="login.php">Login</a></li>
<li><a href="signup.php">Register</a></li>
</ul>';
}

?>

                                        </div>
                                        <div class="main-menu__right-cart-search">

                                            <div class="main-menu__right-search-box">
                                                <a href="#" class="thm-btn search-toggler">Search</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </nav>

                    </div>
                </div>
            </div>

        </header>


        <div class="stricky-header stricked-menu main-menu">
            <div class="sticky-header__content">

            </div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->


        <div class="search-popup">
        <div class="search-popup__overlay search-toggler"></div>
        <!-- /.search-popup__overlay -->
        <div class="search-popup__content">
            <form action="./courses.php" method="GET">
                <!-- ToDO: search  -->
                <label for="search" class="sr-only">search here</label><!-- /.sr-only -->
                <input type="text" id="search" name="s" placeholder="Search Here..." />
                <button type="submit" aria-label="search submit" class="thm-btn2">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </button>
                <div class="search-popup__content" id="suggest-div"  style="display:none;background:#fff; border-radius: 50%;">
                    <!-- ToDo: show subject for search -->
                   <ul style=" list-style-type: none;" id="suggest">

                   </ul>

                </div>
            </form>
        </div>
        <!-- /.search-popup__content -->
    </div>

    <div class="modal fade bd-example-modal-xl" id="SuggestResource" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="model-addUser">Suggest Resource</h5>
                        <button type="button" onclick="CloseMode()" class="btn btn-danger close" data-dismiss="modal" aria-label="Close">
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        </button>
                    </div>
                    <div class="modal-body" id="body-modlae">
                        <div class="course-details__reviews">
                            <h3 class="course-details__reviews-title"></h3>
                            <div class="course-details__add-review">
<!--                                    TODO: Suggest Resource -->
                                <div class="course-details__add-review-form" >
                                    <!-- ToDo: add  alert of Add a report -->
                                    <div style="display: none" id="alert-success"  class="alert alert-success" >

                                    </div>
                                    <div style="display: none ;background: #f1a2a2" id="alert-danger" class="alert alert-danger" >

                                    </div>
                                    <div   class="comment-one__form " >

                                        <div class="row">
                                            <div class="row">

                                                <div class="col-xl-12 col-lg-12">
                                                    <div class="comment-form__input-box">
                                                        <input type="text" id="suggest_link" placeholder="link"  required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12">
                                                <div class="comment-form__input-box">
                                                    <textarea  id="suggest_description" placeholder="description"></textarea>
                                                </div>

                                                <button class="btn btn-primary"  onclick="submitSuggest()">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                    <div class="modal-footer">
                        <button onclick="CloseMode()" class="btn btn-outline-danger" data-dismiss="modal"><i class="flaticon-cancel-12"></i> close</button>
                    </div>
                </div>

            </div>

        </div>


    <script src="assetsMainPage/vendors/jquery/jquery-3.5.1.min.js"></script>
    <script>
        function SuggestResource(){
            $('#SuggestResource').modal('show');
        }
        function CloseMode(){
            $('#SuggestResource').modal('hide');
        }
        function submitSuggest(){
            var suggest_link=$('#suggest_link').val();

            var suggest_description=$('#suggest_description').val();

            $('#alert-success').hide();
            $('#alert-danger').hide();
            if(suggest_link!='' && suggest_description!=''){

                $.ajax({

                    url:'main_page.php',

                    type:'POST',

                    data:{
                        "add_resource_suggest":1,
                        "suggest_description":suggest_description,
                        "suggest_link":suggest_link
                    },

                    success: function(data){

                        if(!data.localeCompare("SUCCESS RESOURCE SUGGEST")){
                            $('#alert-success').show();
                            document.getElementById('alert-success').innerHTML = data;
                            setTimeout(function (){
                                $('#alert-success').hide();
                            },5000)


                        }

                        else{
                            $('#alert-danger').show();
                            document.getElementById('alert-danger').innerHTML = data;
                            setTimeout(function (){
                                $('#alert-danger').hide();
                            },5000)





                        }

                    }



                });

            }else{
                $('#alert-danger').show();
                document.getElementById('alert-danger').innerHTML = 'Complete the items';
                setTimeout(function (){
                    $('#alert-danger').hide();
                },5000)




            }

        }

    </script>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>


    <?php include "script_search.php";?>