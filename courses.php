<?php

require_once "./Constants/db_queries.php";
require_once "./Constants/messages.php";
require_once "./functions.php";
require_once "./Database/functions.php";
ob_start();
session_start();
$userImg = "assetsMainPage/images/test1.jpg";
$user = null;
if (isset($_SESSION['user'])) {
    $user = select(QUERY_FETCH_USER_ATTRS_BY_USERNAME, "s", [$_SESSION['user']])[0];
    if (!empty($user[5])) {
        $userImg = "uploads/" . $user[5];
    }

}

if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    unset($_SESSION['role']);
}
$field = "";
$field_id = -1;
$search = "";
$field_url = 'assetsMainPage/images/test1.jpg';
$field_date = "";
if (isset($_GET['field'])) {

    $field_id = $_GET['field'];
    $field = select(QUERY_GET_FIELD, "i", [$field_id])[0];
    $field_date = new DateTime($field[1]);
    if (!empty($field[3])) {
        $field_url = "uploads/" . $field[3];
    }
    $field = $field[2];
}
$search = "";
if (isset($_GET['s'])) {
    $search = $_GET['s'];
}

$tagID = "";
$tag = "";
if (isset($_GET['tag'])) {
    $tagID = (int) $_GET['tag'];
    $res = select(QUERY_GET_TAG_BY_ID, "i", [$tagID]);
    if (is_array($res) && sizeof($res) > 0) {
        $tag = $res[0];
    }
}

$topicID = "";
$sh_topic = "";
if (isset($_GET['topic'])) {
    $topicID = $_GET['topic'];
    $res = select(QUERY_GET_TOPIC_BY_ID, "i", [$topicID]);
    if (is_array($res) && sizeof($res) > 0) {
        $sh_topic = $res;
    }

}
$allFields = select(QUERY_GET_ALL_FIELDS, "", []);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TrainSE <?php
if (!empty($field)) {
    echo " | Category " . $field;
}
if (!empty($search)) {
    echo " | " . $search;
}
if (!empty($tagID)) {
    echo " | #" . $tag[2];
}
if (!empty($topicID)) {
    echo " | " . $sh_topic[0][3] . " Topic";
}
?> </title>
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="assetsMainPage/images/favicons/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="assetsMainPage/images/favicons/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="assetsMainPage/images/favicons/favicon-16x16.png" />
    <link rel="manifest" href="assetsMainPage/images/favicons/site.webmanifest" />
    <meta name="description" content="Crsine HTML Template For Car Services" />

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@300;400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assetsMainPage/vendors/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assetsMainPage/vendors/animate/animate.min.css"/>
    <link rel="stylesheet" href="assetsMainPage/vendors/animate/custom-animate.css" />
    <link rel="stylesheet" href="assetsMainPage/vendors/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="assetsMainPage/vendors/jarallax/jarallax.css" />
    <link rel="stylesheet" href="assetsMainPage/vendors/jquery-magnific-popup/jquery.magnific-popup.css" />
    <link rel="stylesheet" href="assetsMainPage/vendors/nouislider/nouislider.min.css" />
    <link rel="stylesheet" href="assetsMainPage/vendors/nouislider/nouislider.pips.css" />
    <link rel="stylesheet" href="assetsMainPage/vendors/odometer/odometer.min.css" />
    <link rel="stylesheet" href="assetsMainPage/vendors/swiper/swiper.min.css" />
    <link rel="stylesheet" href="assetsMainPage/vendors/icomoon-icons/style.css">
    <link rel="stylesheet" href="assetsMainPage/vendors/tiny-slider/tiny-slider.min.css" />
    <link rel="stylesheet" href="assetsMainPage/vendors/reey-font/stylesheet.css" />
    <link rel="stylesheet" href="assetsMainPage/vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="assetsMainPage/vendors/owl-carousel/owl.theme.default.min.css" />
    <link rel="stylesheet" href="assetsMainPage/vendors/twentytwenty/twentytwenty.css" />

    <!-- template styles -->
    <link rel="stylesheet" href="assetsMainPage/css/zilom.css" />
    <link rel="stylesheet" href="assetsMainPage/css/zilom-responsive.css" />
</head>

<body>


   <?php
require_once "starter_menu.php";

?>

    <section class="page-header clearfix" style="background-image: url(<?php echo $field_url; ?>);">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-header__wrapper clearfix">
                        <div class="page-header__title">
                            <h2>
                            <?php
if (!empty($field)) {
    echo $field;
}
if (!empty($search)) {
    echo "Search : '" . $search . "'";
}
if (!empty($tagID)) {

    echo "Resources for '#" . $tag[2] . "'";
}
if (!empty($topicID)) {
    echo "Topic : '" . $sh_topic[0][3] . "'";
}
?></h2>
                        </div>
                        <div class="page-header__menu">
                            <ul class="page-header__menu-list list-unstyled clearfix">
                                <li><a href="../">Home</a></li>
                                <li class="active"> <?php
if (!empty($field)) {
    echo $field;
}
if (!empty($search)) {
    echo $search;
}
if (!empty($tagID)) {
    echo "#" . $tag[2];
}
if (!empty($topicID)) {
    echo $sh_topic[0][3];
}
?></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section class="courses-one courses-one--courses">
        <div class="container">

                <div class="row">
                <!--Start case-studies-one Top-->
                <div class="courses-one--courses__top">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="courses-one--courses__menu-box">
                            <ul class="project-filter clearfix post-filter has-dynamic-filters-counter list-unstyled">

                                <?php
if (isset($_GET['field'])) {
    $topics = fetch_topics($field_id);
    echo '<li data-filter=".filter-item" class="active"><span class="filter-text">All</span></li>';
    if ($topics != null) {

        foreach ($topics as $t) {
            echo '<li data-filter=".' . $t[0] . '"><span class="filter-text">' . $t[3] . '</span></li>';
        }

    }
} else {
    if (empty($topicID) && empty($tagID) && empty($search)) {
        $fields = select(QUERY_GET_ALL_FIELDS, "", []);
        if ($fields != null) {

            foreach ($fields as $f) {
                echo '<li data-filter=".' . $f[0] . '"><span class="filter-text">' . $f[2] . '</span></li>';
            }

        }
    }
}

?>

                            </ul>
                        </div>
                    </div>
                </div>
                <!--End case-studies-one Top-->
            </div>

            <?php
if (isset($_GET['field'])) {
    $allCourses = select(QUERY_GET_FIELD_COURSES, "i", [$field_id]);
} else {
    if (isset($_GET['tag'])) {
        $allCourses = select(QUERY_GET_TAG_RESOURCES, "i", [$tagID]);
    } else if (isset($_GET['topic'])) {
        $allCourses = select(QUERY_GET_TOPIC_RESOURCES, "s", [$topicID]);
    } else if (isset($_GET['s'])) {
        $allCourses = select(QUERY_GET_RESOURCE_BY_DATE, "s", [$search]);
        if ($_GET['s'][0] == "#") {
            $allCourses = select(QUERY_GET_SEARCH_TAG_RESOURCES, "s", [substr($_GET['s'], 1, strlen($_GET['s']) - 1)]);
        }
    }

}

?>
            <div class="row filter-layout masonary-layout">
                <!--Start Single Courses One-->
                <?php

if ($allCourses != null) {
    foreach ($allCourses as $c) {
        $curl = "./uploads/" . $c[4];
        $creator = findCreator($c[0]);
        $stars = "";
        $topics = "";
        $tp = "";
        if (isset($_GET['field'])) {
            foreach (getTopics($c[0]) as $t) {
                $topics .= '<a href="courses.php?topic=' . $t[0] . '"><p>' . $t[3] . '</p></a>';
                $tp .= $t[0] . " ";
            }
        } else {
            foreach (getTopics($c[0]) as $t) {
                $topics .= '<a href="courses.php?topic=' . $t[0] . '"><p>' . $t[3] . '</p></a>';
            }
            foreach (getFields($c[0]) as $f) {
                $tp .= $f[0] . " ";
            }
        }
        $meanRate = MeanRate($c[0]);
        for ($x = 0; $x < 5; $x++) {
            // TODO show inactive stars
            if ($x < $meanRate[0]) {
                $stars .= '<li><i class="fa fa-star"></i></li>';
            } else {
                $stars .= '<li><i class="far fa-star"></i></li>';
            }
        }

        echo '<div class="col-xl-3 col-lg-6 col-md-6 filter-item ' . $tp . '">
                    <div class="courses-one__single wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1000ms">
                       <a href="course_details.php?resource=' . $c[0] . '">
                        <div class="courses-one__single-img">

                         <img   style="height:201px;" src="' . $curl . '" alt=""/>




                            <div class="overlay-text">
                                ' . $topics . '
                            </div>
                        </div>
                        </a>
                        <div class="courses-one__single-content">
                            <h6 class="courses-one__single-content-name">' . $creator[1] . ' ' . $creator[2] . '</h6>
                            <h4 class="courses-one__single-content-title"><a href="course_details.php?resource=' . $c[0] . '">' . $c[1] . '</a></h4>
                            <div class="courses-one__single-content-review-box">
                                <ul class="list-unstyled">
                                        ' . $stars . '
                                </ul>
                                <div class="rateing-box">
                                    <span>(' . $meanRate[1] . ')</span>
                                </div>
                            </div>

                            <ul class="courses-one__single-content-courses-info list-unstyled">
                                <li>' . dateTostr($c[6]) . '</li>
                                <li>' . convertToHoursMins($c[5]) . '</li>

                            </ul>
                        </div>
                    </div>
                </div>';
    }
}
?>




            </div>
            </div>
        </div>
    </section>



    <!--Start Footer One-->
    <footer class="footer-one">
        <div class="footer-one__bg" style="background-image: url(assetsMainPage/images/test1.jpg);">
        </div><!-- /.footer-one__bg -->


        <!--Start Footer One Bottom-->
        <div class="footer-one__bottom">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="footer-one__bottom-inner">
                            <div class="footer-one__bottom-text text-center">
                                <p>&copy; Copyright 2021 by TrainSE.ir</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End Footer One Bottom-->
    </footer>
    <!--End Footer One-->









    </div><!-- /.page-wrapper -->



    <div class="mobile-nav__wrapper">
        <div class="mobile-nav__overlay mobile-nav__toggler"></div>
        <!-- /.mobile-nav__overlay -->
        <div class="mobile-nav__content">
            <span class="mobile-nav__close mobile-nav__toggler"><i class="fa fa-times"></i></span>

            <!-- /.logo-box -->
            <div class="mobile-nav__container"></div>
            <!-- /.mobile-nav__container -->

            <ul class="mobile-nav__contact list-unstyled">
                <li>
                    <i class="icon-phone-call"></i>
                    <a href="mailto:needhelp@packageName__.com">needhelp@zilom.com</a>
                </li>
                <li>
                    <i class="icon-letter"></i>
                    <a href="tel:666-888-0000">666 888 0000</a>
                </li>
            </ul><!-- /.mobile-nav__contact -->
            <div class="mobile-nav__top">
                <div class="mobile-nav__social">
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-facebook-square"></a>
                    <a href="#" class="fab fa-pinterest-p"></a>
                    <a href="#" class="fab fa-instagram"></a>
                </div><!-- /.mobile-nav__social -->
            </div><!-- /.mobile-nav__top -->
        </div>
        <!-- /.mobile-nav__content -->
    </div>
    <!-- /.mobile-nav__wrapper -->





    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>


    <script src="assetsMainPage/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assetsMainPage/vendors/jarallax/jarallax.min.js"></script>
    <script src="assetsMainPage/vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js"></script>
    <script src="assetsMainPage/vendors/jquery-appear/jquery.appear.min.js"></script>
    <script src="assetsMainPage/vendors/jquery-circle-progress/jquery.circle-progress.min.js"></script>
    <script src="assetsMainPage/vendors/jquery-magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="assetsMainPage/vendors/jquery-validate/jquery.validate.min.js"></script>
    <script src="assetsMainPage/vendors/nouislider/nouislider.min.js"></script>
    <script src="assetsMainPage/vendors/odometer/odometer.min.js"></script>
    <script src="assetsMainPage/vendors/swiper/swiper.min.js"></script>
    <script src="assetsMainPage/vendors/tiny-slider/tiny-slider.min.js"></script>
    <script src="assetsMainPage/vendors/wnumb/wNumb.min.js"></script>
    <script src="assetsMainPage/vendors/wow/wow.js"></script>
    <script src="assetsMainPage/vendors/isotope/isotope.js"></script>
    <script src="assetsMainPage/vendors/countdown/countdown.min.js"></script>
    <script src="assetsMainPage/vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="assetsMainPage/vendors/twentytwenty/twentytwenty.js"></script>
    <script src="assetsMainPage/vendors/twentytwenty/jquery.event.move.js"></script>


    <script src="http://maps.google.com/maps/api/js?key=AIzaSyATY4Rxc8jNvDpsK8ZetC7JyN4PFVYGCGM"></script>

    <!-- template js -->
    <script src="assetsMainPage/js/zilom.js"></script>
    <script>

        getAllResources();

        function showeReportform(){
            $('#report-form').show();
        }
    </script>


</body>

</html>
