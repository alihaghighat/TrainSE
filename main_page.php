<?php

require_once "./Database/functions.php";
require_once "./Constants/messages.php";
require_once "./functions.php";
require_once "./Constants/db_queries.php";
ob_start();

session_start();

$top_fields = select(QUERY_GET_TOP_FIELDS, "", []);
$suggest_msg = "";
if (isset($_POST['add_resource_suggest'])) {
    $link = $_POST['suggest_link'];
    $description = $_POST['suggest_description'];

    if (manipulate(QUERY_ADD_RESOURCE_SUGGEST, "iss", [getStdID($_SESSION['user']), $link, $description]) == 1) {
        $suggest_msg = "SUCCESS RESOURCE SUGGEST";
        echo $suggest_msg;
        return;
    } else {
        $suggest_msg = "Something's wrong, please try again later";
        echo $suggest_msg;
        return;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TrainSE || Home</title>
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
    <link rel="stylesheet" href="assetsMainPage/vendors/animate/animate.min.css" />
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


        <div class="stricky-header stricked-menu main-menu">
            <div class="sticky-header__content">

            </div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->


        <section class="main-slider main-slider-one">
            <div class="swiper-container thm-swiper__slider" data-swiper-options='{"slidesPerView": 1, "loop": true, "effect": "fade", "pagination": {
        "el": "#main-slider-pagination",
        "type": "bullets",
        "clickable": true
        },
        "navigation": {
        "nextEl": "#main-slider__swiper-button-next",
        "prevEl": "#main-slider__swiper-button-prev"
        },
        "autoplay": {
        "delay": 7000
        }}'>

                <div class="swiper-wrapper">
                    <!--Start Single Swiper Slide-->
                    <div class="swiper-slide">
                        <div class="shape1"><img src="assetsMainPage/images/shapes/slider-v1-shape1.png" alt="" /></div>
                        <div class="shape2"><img src="assetsMainPage/images/shapes/slider-v1-shape2.png" alt="" /></div>
                        <div class="image-layer"
                            style="background-image: url(assetsMainPage/images/test1.jpg);"></div>
                        <!-- /.image-layer -->
                        <div class="container">
                            <div class="main-slider__content">
                                <div class="main-slider__content-icon-one">
                                    <span class="icon-lamp"></span>
                                </div>
                                <div class="main-slider__content-icon-two">
                                    <span class="icon-human-resources"></span>
                                </div>
                                <div class="main-slider-one__round-box">
                                    <div class="main-slider-one__round-box-inner">
                                        <p>Professional <br>teachers</p>
                                        <div class="icon">
                                            <i class="fas fa-sort-up"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="main-slider__content-tagline">
                                    <h2>Ready to learn?</h2>
                                </div>
                                <h2 class="main-slider__content-title">Learn new <br>things daily</h2>
                                <p>
                                    <br>
                                </p>
                                <div class="main-slider__content-btn">
                                    <a href="#" class="thm-btn">Discover more</a>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!--End Single Swiper Slide-->

                </div>

                <!-- If we need navigation buttons -->
                <div class="swiper-pagination" id="main-slider-pagination"></div>
                <div class="main-slider__nav">
                    <div class="swiper-button-prev" id="main-slider__swiper-button-next">
                        <span class="icon-left"></span>
                    </div>
                    <div class="swiper-button-next" id="main-slider__swiper-button-prev">
                        <span class="icon-right"></span>
                    </div>
                </div>

            </div>
        </section>

         <!--Categories One Start-->
         <section class="categories-one " style="margin-top: 20px;">
            <div class="container">
                <div class="section-title text-center">

                    <h2 class="section-title__title">Top Categories</h2>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="categories-one__wrapper">
                            <div class="row">

                                <?php
if ($top_fields != null) {
    for ($i = 0; $i < max(min(4, sizeof($top_fields)), min(8, sizeof($top_fields))); $i++) {

        $f = $top_fields[$i];
        $imgUrl = "assetsMainPage/images/test1.jpg";
        if (!empty($f[3])) {
            $imgUrl = "uploads/" . $f[3];
        }

        echo '<div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="200ms"
        data-wow-duration="1500ms">
        <a href="courses.php?field=' . $f[0] . '"><div class="categories-one__single">
            <div class="categories-one__single-img">
                <img src="' . $imgUrl . '" style="height: 329px;" alt="" />
                <div class="categories-one__single-overlay">
                    <div class="categories-one__single-overlay-text1">
                        <p>' . $f[5] . ' Courses</p>
                    </div>
                    <div class="categories-one__single-overlay-text2">
                          <!-- ToDo: Name of category -->
                        <h4>' . $f[2] . '</h4>
                    </div>
                </div>
            </div>
        </div></a>
    </div>';
    }
}
?>



                            </div>
                        </div>
                        <div class="categories-one__btn text-center">
                              <!-- ToDo: link to serach page to show all course -->
                            <a href="courses.php" class="thm-btn">view all courses</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Categories One End-->
        <section class="courses-one">
            <div class="container">
                <div class="section-title text-center">
                    <span class="section-title__tagline">Checkout New List</span>
                    <h2 class="section-title__title">Explore Courses</h2>
                </div>
                <div class="row">
                    <!--Start Single Courses One-->
                    <?php
$allCourses = select(QUERY_GET_RESOURCE_BY_DATE, "s", [""]);
if ($allCourses != null) {
    for ($i = 0; $i < min(8, sizeof($allCourses)); $i++) {
        $c = $allCourses[$i];
        $curl = "./uploads/" . $c[4];
        $creator = findCreator($c[0]);
        $stars = "";
        $topics = "";
        foreach (getTopics($c[0]) as $t) {
            $topics .= '<a href="courses.php?topic=' . $t[0] . '"><p>' . $t[3] . '</p></a>';
        }

        $meanRate = MeanRate($c[0]);
        for ($x = 0; $x < 5; $x++) {
            if ($x < $meanRate[0]) {
                $stars .= '<li><i class="fa fa-star"></i></li>';
            } else {
                $stars .= '<li><i class="far fa-star"></i></li>';
            }
        }

        echo '<div class="col-xl-3 col-lg-6 col-md-6 filter-item">
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

            <div class="logo-box">
                <a href="index.html" aria-label="logo image"><img src="assetsMainPage/images/resources/mobilemenu_logo.png"
                        width="155" alt="" /></a>
            </div>
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


<!--    <script src="assetsMainPage/vendors/jquery/jquery-3.5.1.min.js"></script>-->
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
    <script src="assetsMainPage/vendors/parallax/parallax.min.js"></script>


    <script src="http://maps.google.com/maps/api/js?key=AIzaSyATY4Rxc8jNvDpsK8ZetC7JyN4PFVYGCGM"></script>

    <!-- template js -->
    <script src="assetsMainPage/js/zilom.js"></script>


</body>

</html>
