<?php
require_once "./functions.php";
require_once "./Constants/messages.php";
require_once "./Constants/db_queries.php";
require_once "./Constants/db_names.php";
ob_start();
session_start();

$is_bookmarked = false;

$rid = -1;
if (isset($_GET['resource'])) {
    $rid = $_GET['resource'];
    $all_comments = select(QUERY_FETCH_COMMENTS, "i", [$rid]);

} else if (isset($_POST['resource'])) {
    $rid = $_POST['resource'];
} else {
    alert(ERR_RESOURCE_NOT_GIVEN);
}

$resource = select(QUERY_GET_RESOURCE_BY_ID, "i", [$rid]);
if (is_array($resource)) {
    $resource = $resource[0];
}
$img = "assetsMainPage/images/test1.jpg";
if (!empty($resource[4])) {
    $img = "uploads/" . $resource[4];
}
$topics = getTopics($rid);
$creator = select(QUERY_GET_RESOURCE_CREAETOR, "i", [$rid]);
if (is_array($creator)) {
    $creator = $creator[0];
}

$report_msg = "";
if (isset($_POST['report-resource'])) {
    if (manipulate(QUERY_ADD_REPORT, "sssis", [date("Y-m-d H:i:s"), $_POST['type-report'], DB_REPORT_IGNORED, $rid, $_SESSION['user']]) == 1) {
        $report_msg = SUCCESS_REPORT;
    } else {
        $report_msg = "Something's wrong, try agin later";
    }
}

$rate_msg = "";
if (isset($_GET['star'])) {
    if (manipulate(QUERY_ADD_RATE, "sis", [$_GET['star'] . "star", $rid, $_SESSION['user']]) == 1) {
        $rate_msg = SUCCESS_RATE;
    } else {
        $rate_msg = "Something's wrong, try agin later";
    }
    unset($_GET['star']);

}

if (isset($_POST['delete-resource-btn'])) {
    if (manipulate(QUERY_DELETE_RESOURCE, "i", [$rid]) == 1) {
        header("location: main_page.php");
    }
}

if (isset($_POST['add-to-bookmark-btn'])) {
    if (manipulate(QUERY_ADD_TO_BOOKMARK, "is", [$rid, $_SESSION['user']]) == 1) {
        //header("location: see_my_courses.php");
    }
}

if (isset($_POST['remove-bookmark-btn'])) {
    if (manipulate(QUERY_REMOVE_BOOKMARK, "is", [$rid, $_SESSION['user']]) == 1) {
        //header("location: see_my_courses.php");
    }
}

if (isset($_POST['submit-comment'])) {
    if (manipulate(QUERY_ADD_COMMENT, "sis", [$_POST['message'], $rid, $_SESSION['user']]) == 1) {
        header("location: course_details.php?resource=" . $rid);
    }
}

function is_comment_liked($comment_id)
{
    $is_liked = select(QUERY_CHECK_IF_COMMENT_LIKED, "s", [$_SESSION['user']]);
    $ok = false;
    if (is_array($is_liked)) {
        foreach ($is_liked as $is_like) {
            if ($is_like[11] == $comment_id) {
                $ok = true;
            }
        }
    }
    if ($ok) {
        return true;
    } else {
        return false;
    }
}

function like_count($comment_id)
{
    $like_counts = select(QUERY_COUNT_LIKES, "i", [$comment_id]);
    if (is_array($like_counts)) {
        return count($like_counts);
    } else {
        return 0;
    }
}

if (isset($_GET['add_like'])) {
    if (manipulate(QUERY_ADD_LIKE, "is", [$_GET['add_like'], $_SESSION['user']]) == 1) {
        header("location: course_details.php?resource=" . $rid);
    }
}

if (isset($_GET['remove_like'])) {
    if (manipulate(QUERY_DELETE_LIKE, "is", [$_GET['remove_like'], $_SESSION['user']]) == 1) {
        header("location: course_details.php?resource=" . $rid);
    }
}

function getResourceRate($resource_id, $username)
{

    $resource_rates = select(QUERY_GET_RESOURCE_RATE_BY_RESOURCE_ID, "i", [$resource_id]);

    if (is_array($resource_rates)) {
        foreach ($resource_rates as $resource_rate) {
            if ($resource_rate[4] == $username) {
                return $resource_rate[2];
            }
        }
    }
    return "0star";

}

$resource_examples = select(QUERY_GET_EXAMPLES_BY_RESOURCE_ID, "i", [$rid]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TrainSE || Course Details</title>
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



<!--Start Course Details-->
<section class="course-details">
    <div class="container">
        <div class="row">
            <!--Start Course Details Content-->
            <div class="col-xl-8 col-lg-8">
                <div class="course-details__content">
                    <!--Start Single Courses One-->
                    <div class="courses-one__single style2 wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1000ms">
                        <div class="courses-one__single-img">
                            <img src="<?php echo $img; ?>" alt=""/>
                            <div class="overlay-text">
                                <?php
foreach ($topics as $t) {
    echo '<a href="courses.php?topic=' . $t[0] . '"><p>' . $t[3] . '</p></a>';
}
?>
                            </div>
                        </div>
                        <div class="courses-one__single-content">
                            <h6 class="courses-one__single-content-name">  <?php echo $creator[0] . '<span>' . dateTostr($resource[6]); ?></span></h6>
                            <h4 class="courses-one__single-content-title"><?php echo $resource[1]; ?></h4>
                            <div class="courses-one__single-content-review-box">
                                <ul class="list-unstyled">
                                    <?php
$meanRate = MeanRate($resource[0]);
for ($x = 0; $x < 5; $x++) {
    if ($x < $meanRate[0]) {
        echo '<li><i class="fa fa-star"></i></li>';
    } else {
        echo '<li><i class="far fa-star"></i></li>';
    }
}
?>

                                </ul>
                                <div class="rateing-box">
                                    <span>(<?php echo $meanRate[1]; ?>)</span>
                                </div>
                            </div>
                            <div class="course-details__content-text1">
                                <p><?php echo $resource[2]; ?></p>
                            </div>

                            <?php if (isset($_SESSION['user'])) {
    echo '<div id="report-form-show"></div>';
}
?>


                        </div>
                    </div>
                    <!--End Single Courses One-->
                    <div class="course-details__reviews" id="report-form" style="display: none;">
                        <h3 class="course-details__reviews-title">report</h3>
                        <div class="course-details__add-review">

                            <div class="course-details__add-review-form" >
                                <?php if (!empty($report_msg)) {
    echo '<div id="report_msg" class="alert">' . $report_msg . '</div>';
}
?>
                                <form action="" class="comment-one__form " method="POST" autocomplete="off" >

                                    <div class="row">

                                        <div class="col-xl-12 col-lg-12">
                                            <form autocomplete="off" method="POST">
                                                <div class="comment-form__input-box">
                                                    <select name="type-report">
                                                        <option value="<?php echo DB_REPORT_TYPE1; ?>"><?php echo DB_REPORT_TYPE1; ?></option>
                                                        <option value="<?php echo DB_REPORT_TYPE2; ?>"><?php echo DB_REPORT_TYPE2; ?></option>
                                                    </select>
                                                </div>
                                                <input name="resource" value="<?php echo $rid; ?>" style="display:none;" />
                                                <button type="submit" name="report-resource" class="thm-btn comment-form__btn">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>



                    </div>
                    <!--Start Course Details Reviews-->
                    <div class="course-details__reviews" id="review-form">
                        <h3 class="course-details__reviews-title">Comments</h3>



                        <?php
if (isset($_SESSION['user'])) {
    echo '
    <div class="course-details__add-review">
                                <h2 class="course-details__add-review-title">Add a Comment</h2>


                                <div class="course-details__add-review-form" >';
    if (!empty($rate_msg)) {
        echo '<div id="rate_msg" class="alert">' . $rate_msg . '</div>';
    }

    echo '
<form action="" class="comment-one__form contact-form-validated" novalidate="novalidate">

                                        <div class="row">';

    if (!isRated($_SESSION['user'], $rid)) {

        echo '<div class="col-xl-12 col-lg-12" style="margin-bottom: 20px;">
            <p class="course-details__add-review-text">
                Rate this Course?
                <a href="?resource=' . $rid . '&star=1#review-form" class="fas fa-star active "></a>
                <a href="?resource=' . $rid . '&star=2#review-form" class="fas fa-star active"></a>
                <a href="?resource=' . $rid . '&star=3#review-form" class="fas fa-star active"></a>
                <a href="?resource=' . $rid . '&star=4#review-form" class="fas fa-star"></a>
                <a href="?resource=' . $rid . '&star=5#review-form" class="fas fa-star"></a>
            </p>
        </div>';
    } else {
        echo '<div class="courses-one__single-content-review-box">
    <ul class="list-unstyled">';
        $meanRate = MeanRate($resource[0]);
        for ($x = 0; $x < 5; $x++) {
            if ($x < $meanRate[0]) {
                echo '<li><i class="fas fa-star active"></i></li>';
            } else {
                echo '<li><i class="far fa-star"></i></li>';
            }
        }
        echo ' </ul>
    </div>';
    }
    if (!empty($comment_msg)) {
        echo '<div id="comment_msg" class="alert">' . $rate_msg . '</div>';
    }
    echo '<div class="col-xl-12 col-lg-12">
                                                </form>
                                                <form method="post" >

                                                <div class="comment-form__input-box">
                                                    <textarea name="message" placeholder="Write message" required></textarea>
                                                </div>
                                                <button type="submit" name="submit-comment" class="thm-btn comment-form__btn">Submit comment</button>
                                                </form>
                                            </div>
                                        </div>


                                      </div>
                            </div>';
}
?>




                        <?php
if (is_array($all_comments)) {
    foreach ($all_comments as $comment) {
        $commenter_attributes = select(QUERY_FETCH_USER_ATTRS_BY_USERNAME, "s", [$comment[3]]);
        $commneter_username = $commenter_attributes[0][0];
        $commenter_firstname = $commenter_attributes[0][1];
        $commenter_lastname = $commenter_attributes[0][2];
        $commenter_imgName = $commenter_attributes[0][5];

        $resource_rate = getResourceRate($rid, $commneter_username);

        echo '
                            <!--Start Course Details Comment-->
                            <div class="course-details__comment">

                                <div class="course-details__comment-single">
                                    <div class="course-details__comment-img">
                                        <img src="uploads/' . $commenter_imgName . '" width="80px" alt=""/>
                                    </div>
                                    <div class="course-details__comment-text">
                                        <div class="course-details__comment-text-top">
                                            <h3 class="course-details__comment-text-name">' . $commenter_firstname . ' ' . $commenter_lastname . '</h3>
                                            <p>' . substr($comment[2], 0, 10) . '</p>
                                            <div class="course-details__comment-review-stars">';
        if ($resource_rate == "0star") {
            echo '<i class="far fa-star"></i>
                                                      <i class="far fa-star"></i>
                                                      <i class="far fa-star"></i>
                                                      <i class="far fa-star"></i>
                                                      <i class="far fa-star"></i>';
        } else if ($resource_rate == "1star") {
            echo '<i class="fas fa-star"></i>
                                                      <i class="far fa-star"></i>
                                                      <i class="far fa-star"></i>
                                                      <i class="far fa-star"></i>
                                                      <i class="far fa-star"></i>';
        } else if ($resource_rate == "2star") {
            echo '<i class="fas fa-star"></i>
                                                      <i class="fas fa-star"></i>
                                                      <i class="far fa-star"></i>
                                                      <i class="far fa-star"></i>
                                                      <i class="far fa-star"></i>';
        } else if ($resource_rate == "3star") {
            echo '<i class="fas fa-star"></i>
                                                      <i class="fas fa-star"></i>
                                                      <i class="fas fa-star"></i>
                                                      <i class="far fa-star"></i>
                                                      <i class="far fa-star"></i>';
        } else if ($resource_rate == "4star") {
            echo '<i class="fas fa-star"></i>
                                                      <i class="fas fa-star"></i>
                                                      <i class="fas fa-star"></i>
                                                      <i class="fas fa-star"></i>
                                                      <i class="far fa-star"></i>';
        } else {
            echo '<i class="fas fa-star"></i>
                                                      <i class="fas fa-star"></i>
                                                      <i class="fas fa-star"></i>
                                                      <i class="fas fa-star"></i>
                                                      <i class="fas fa-star"></i>';
        }

        echo '
                                            </div>

                                        </div>
                                        <div class="course-details__comment-text-top">
                                        ';
        if (like_count($comment[0]) < 2) {
            echo '<p>' . like_count($comment[0]) . ' like</p>';
        } else {
            echo '
                                            <p>' . like_count($comment[0]) . ' likes</p>';
        }
        echo ' <div class="course-details__comment-review-stars">';
        if (isset($_SESSION['user'])) {
            echo '



                                                <!-- if user not  like this comment -->';

            if (!is_comment_liked($comment[0])) {

                echo '

                                                <a href="' . $_SERVER['REQUEST_URI'] . '&add_like=' . $comment[0] . '"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                                    width="30" height="30"
                                                    viewBox="0 0 172 172"
                                                    style=" fill:#000000;"><g transform="translate(4.73,4.73) scale(0.945,0.945)"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="none" stroke-linecap="butt" stroke-linejoin="none" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g fill="#e74c3c" stroke="#e74c3c" stroke-width="10" stroke-linejoin="round"><path d="M86,40.13333c0,0 11.46711,-17.2 31.27578,-17.2c20.726,0 37.52422,16.79822 37.52422,37.52422c0,36.16251 -42.06484,70.7263 -61.55495,86.02239c-0.0371,0.03384 -0.07443,0.06743 -0.11198,0.10078c-0.02959,0.02321 -0.07131,0.05526 -0.10079,0.07839c-0.03876,0.0304 -0.09579,0.07053 -0.13437,0.10078v-0.0112c-1.98664,1.50111 -4.40792,2.31475 -6.89792,2.31797c-2.48616,-0.00565 -4.90314,-0.81917 -6.88672,-2.31797l-0.0112,0.0112c-0.13183,-0.10335 -0.31396,-0.25316 -0.44792,-0.35833c-0.01871,-0.01487 -0.03737,-0.0298 -0.05599,-0.04479c-19.55072,-15.35126 -61.39817,-49.8228 -61.39817,-85.89922c0,-20.726 16.79822,-37.52422 37.52422,-37.52422c19.80867,0 31.27578,17.2 31.27578,17.2z"></path></g><path d="M0,172v-172h172v172z" fill="none" stroke="none" stroke-width="1" stroke-linejoin="miter"></path><g fill="#ffffff" stroke="none" stroke-width="1" stroke-linejoin="miter"><path d="M54.72422,22.93333c-20.726,0 -37.52422,16.79822 -37.52422,37.52422c0,36.07642 41.84746,70.54796 61.39817,85.89922c0.01862,0.01499 0.03728,0.02992 0.05599,0.04479c0.13396,0.10517 0.31608,0.25498 0.44792,0.35833l0.0112,-0.0112c1.98358,1.4988 4.40056,2.31232 6.88672,2.31797c2.48999,-0.00322 4.91127,-0.81686 6.89792,-2.31797v0.0112c0.03859,-0.03025 0.09561,-0.07038 0.13437,-0.10078c0.02948,-0.02312 0.0712,-0.05517 0.10079,-0.07839c0.03755,-0.03335 0.07487,-0.06694 0.11198,-0.10078c19.49011,-15.2961 61.55495,-49.85989 61.55495,-86.02239c0,-20.726 -16.79822,-37.52422 -37.52422,-37.52422c-19.80867,0 -31.27578,17.2 -31.27578,17.2c0,0 -11.46711,-17.2 -31.27578,-17.2z"></path></g><path d="" fill="none" stroke="none" stroke-width="1" stroke-linejoin="miter"></path></g></g></svg>
                                                </a>';
            } else {
                echo '
                                                 <!-- if user like this comment -->
                                                 <a href="' . $_SERVER['REQUEST_URI'] . '&remove_like=' . $comment[0] . '">
                                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                                    width="30" height="30"
                                                    viewBox="0 0 172 172"
                                                    style=" fill:#000000;"><g transform="translate(4.73,4.73) scale(0.945,0.945)"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="none" stroke-linecap="butt" stroke-linejoin="none" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g fill="#e74c3c" stroke="#e74c3c" stroke-width="10" stroke-linejoin="round"><path d="M86,40.13333c0,0 11.46711,-17.2 31.27578,-17.2c20.726,0 37.52422,16.79822 37.52422,37.52422c0,36.16251 -42.06484,70.7263 -61.55495,86.02239c-0.0371,0.03384 -0.07443,0.06743 -0.11198,0.10078c-0.02959,0.02321 -0.07131,0.05526 -0.10079,0.07839c-0.03876,0.0304 -0.09579,0.07053 -0.13437,0.10078v-0.0112c-1.98664,1.50111 -4.40792,2.31475 -6.89792,2.31797c-2.48616,-0.00565 -4.90314,-0.81917 -6.88672,-2.31797l-0.0112,0.0112c-0.13183,-0.10335 -0.31396,-0.25316 -0.44792,-0.35833c-0.01871,-0.01487 -0.03737,-0.0298 -0.05599,-0.04479c-19.55072,-15.35126 -61.39817,-49.8228 -61.39817,-85.89922c0,-20.726 16.79822,-37.52422 37.52422,-37.52422c19.80867,0 31.27578,17.2 31.27578,17.2z"></path></g><path d="M0,172v-172h172v172z" fill="none" stroke="none" stroke-width="1" stroke-linejoin="miter"></path><g fill="#e74c3c" stroke="none" stroke-width="1" stroke-linejoin="miter"><path d="M54.72422,22.93333c-20.726,0 -37.52422,16.79822 -37.52422,37.52422c0,36.07642 41.84746,70.54796 61.39817,85.89922c0.01862,0.01499 0.03728,0.02992 0.05599,0.04479c0.13396,0.10517 0.31608,0.25498 0.44792,0.35833l0.0112,-0.0112c1.98358,1.4988 4.40056,2.31232 6.88672,2.31797c2.48999,-0.00322 4.91127,-0.81686 6.89792,-2.31797v0.0112c0.03859,-0.03025 0.09561,-0.07038 0.13437,-0.10078c0.02948,-0.02312 0.0712,-0.05517 0.10079,-0.07839c0.03755,-0.03335 0.07487,-0.06694 0.11198,-0.10078c19.49011,-15.2961 61.55495,-49.85989 61.55495,-86.02239c0,-20.726 -16.79822,-37.52422 -37.52422,-37.52422c-19.80867,0 -31.27578,17.2 -31.27578,17.2c0,0 -11.46711,-17.2 -31.27578,-17.2z"></path></g><path d="" fill="none" stroke="none" stroke-width="1" stroke-linejoin="miter"></path></g></g></svg>
                                                </a>
                                                ';
            }
        } else {
            echo '<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                                    width="30" height="30"
                                                    viewBox="0 0 172 172"
                                                    style=" fill:#000000;"><g transform="translate(4.73,4.73) scale(0.945,0.945)"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="none" stroke-linecap="butt" stroke-linejoin="none" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g fill="#e74c3c" stroke="#e74c3c" stroke-width="10" stroke-linejoin="round"><path d="M86,40.13333c0,0 11.46711,-17.2 31.27578,-17.2c20.726,0 37.52422,16.79822 37.52422,37.52422c0,36.16251 -42.06484,70.7263 -61.55495,86.02239c-0.0371,0.03384 -0.07443,0.06743 -0.11198,0.10078c-0.02959,0.02321 -0.07131,0.05526 -0.10079,0.07839c-0.03876,0.0304 -0.09579,0.07053 -0.13437,0.10078v-0.0112c-1.98664,1.50111 -4.40792,2.31475 -6.89792,2.31797c-2.48616,-0.00565 -4.90314,-0.81917 -6.88672,-2.31797l-0.0112,0.0112c-0.13183,-0.10335 -0.31396,-0.25316 -0.44792,-0.35833c-0.01871,-0.01487 -0.03737,-0.0298 -0.05599,-0.04479c-19.55072,-15.35126 -61.39817,-49.8228 -61.39817,-85.89922c0,-20.726 16.79822,-37.52422 37.52422,-37.52422c19.80867,0 31.27578,17.2 31.27578,17.2z"></path></g><path d="M0,172v-172h172v172z" fill="none" stroke="none" stroke-width="1" stroke-linejoin="miter"></path><g fill="#e74c3c" stroke="none" stroke-width="1" stroke-linejoin="miter"><path d="M54.72422,22.93333c-20.726,0 -37.52422,16.79822 -37.52422,37.52422c0,36.07642 41.84746,70.54796 61.39817,85.89922c0.01862,0.01499 0.03728,0.02992 0.05599,0.04479c0.13396,0.10517 0.31608,0.25498 0.44792,0.35833l0.0112,-0.0112c1.98358,1.4988 4.40056,2.31232 6.88672,2.31797c2.48999,-0.00322 4.91127,-0.81686 6.89792,-2.31797v0.0112c0.03859,-0.03025 0.09561,-0.07038 0.13437,-0.10078c0.02948,-0.02312 0.0712,-0.05517 0.10079,-0.07839c0.03755,-0.03335 0.07487,-0.06694 0.11198,-0.10078c19.49011,-15.2961 61.55495,-49.85989 61.55495,-86.02239c0,-20.726 -16.79822,-37.52422 -37.52422,-37.52422c-19.80867,0 -31.27578,17.2 -31.27578,17.2c0,0 -11.46711,-17.2 -31.27578,-17.2z"></path></g><path d="" fill="none" stroke="none" stroke-width="1" stroke-linejoin="miter"></path></g></g></svg>';
        }

        echo '
                                            </div>

                                        </div>
                                        <p class="course-details__comment-text-bottom">' . $comment[1] . '</p>
                                    </div>
                                </div>


                            </div>
                            <!--End Course Details Comment-->';
    }
}
?>


                    </div>
                    <!--End Course Details Reviews-->
                </div>
            </div>
            <!--End Course Details Content-->

            <!--Start Course Details Sidebar-->
            <div class="col-xl-4 col-lg-4">
                <div class="course-details__sidebar">
                    <div class="course-details__price wow fadeInUp animated" data-wow-delay="0.1s">
                        <div class="course-details__price-btn">
                            <a   target="_blank" href="<?php echo $resource[3]; ?>" class="thm-btn">Link</a>
                        </div>
                        <div class="course-details__price-btn">
                            <?php if (isset($_SESSION['user'])) {
    echo '<a href="#report-form-show" onclick="showeReportform()" class="thm-btn" style="background-color: peru;">report</a>';
}
?>

                        </div>
                        <div class="course-details__price-btn">
                            <!-- ToDo: showeExample -->
                            <?php
if (is_array($resource_examples)) {
    echo '
                            <button onclick="showeExample()" style="background-color: #a4bdf7;" class="thm-btn">Example</button>';
}

?>

                        </div>
                    </div>

                    <div class="course-details__sidebar-meta wow fadeInUp animated" data-wow-delay="0.3s">
                        <div  class="alert">

                        </div>
                        <ul class="course-details__sidebar-meta-list list-unstyled">
                            <li class="course-details__sidebar-meta-list-item">
                                <div class="icon">
                                    <a href=""><i class="far fa-clock"></i></a>
                                </div>
                                <div class="text">
                                    <!-- ToDo: Durations of course -->
                                    <p><a href="#">Durations: <span><?php echo convertToHoursMins($resource[5]); ?></span></a></p>
                                </div>
                            </li>
                            <li class="course-details__sidebar-meta-list-item">
                                <div class="icon">

                                    <?php
$bookmarked_resources = select(QUERY_CHECK_IF_BOOKMARKED, "i", [$rid]);
if (is_array($bookmarked_resources)) {
    foreach ($bookmarked_resources as $bookmarked_resource) {
        if ($bookmarked_resource[0] == $_SESSION['user']) {
            $is_bookmarked = true;
            echo '
                                                <a href=""><img src="https://img.icons8.com/color/48/000000/bookmark-ribbon--v1.png" width="50%"/></a>';
            break;
        } else {

            $is_bookmarked = false;
        }

    }
}

if (!$is_bookmarked) {
    echo '
                                                <a href=""><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                                    width="30" height="30"
                                                    viewBox="0 0 172 172"
                                                    style=" fill:#000000;"><g transform="translate(4.73,4.73) scale(0.945,0.945)"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="none" stroke-linecap="butt" stroke-linejoin="none" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g fill="#ffffff" stroke="#ff0000" stroke-width="10" stroke-linejoin="round"><path d="M132.58333,154.08333l-46.58333,-21.5l-46.58333,21.5v-121.83333c0,-7.88333 6.45,-14.33333 14.33333,-14.33333h64.5c7.88333,0 14.33333,6.45 14.33333,14.33333z"></path></g><path d="M0,172v-172h172v172z" fill="none" stroke="none" stroke-width="1" stroke-linejoin="miter"></path><g fill="#ffffff" stroke="none" stroke-width="1" stroke-linejoin="miter"><path d="M132.58333,154.08333l-46.58333,-21.5l-46.58333,21.5v-121.83333c0,-7.88333 6.45,-14.33333 14.33333,-14.33333h64.5c7.88333,0 14.33333,6.45 14.33333,14.33333z"></path></g><path d="" fill="none" stroke="none" stroke-width="1" stroke-linejoin="miter"></path></g></g></svg>
                                    </a>';
}

?>


<!--                                    TODO: icon -->






                                </div>
                                <div class="text">
                                    <!-- ToDo: book mark -->
                                    <form method="post">
                                    <?php
if ($is_bookmarked) {
    echo '
                                                <input type="submit" name="remove-bookmark-btn" value="remove from bookmark" style="outline: none; border: none; background-color: transparent; resize: none; font-size: 15px;" />';
} else {
    echo '
                                                <input type="submit" name="add-to-bookmark-btn" value="add to bookmark" style="outline: none; border: none; background-color: transparent; resize: none; font-size: 15px;" />';
}

?>

                                    </form>
                                </div>
                            </li>
                            <!-- ToDo: if admin or CC can dellet course -->


                            <?php
if ($_SESSION['user_role'] == DB_ROLE_OWNER || $_SESSION['user_role'] == DB_ROLE_ADMIN || $creator == $_SESSION['user']) {
    echo '

                                <li class="course-details__sidebar-meta-list-item">
                                    <div class="icon">
                                        <a href=""><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                            width="32" height="32"
                                            viewBox="0 0 172 172"
                                            style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#e74c3c"><path d="M118.25,166.625c11.85725,0 21.5,-9.64275 21.5,-21.5v-91.375c0,-2.97238 -2.40263,-5.375 -5.375,-5.375h-96.75c-2.97237,0 -5.375,2.40262 -5.375,5.375v91.375c0,11.85725 9.64275,21.5 21.5,21.5zM43,145.125v-86h86v86c0,5.92863 -4.82137,10.75 -10.75,10.75h-64.5c-5.92862,0 -10.75,-4.82137 -10.75,-10.75z"></path><path d="M145.125,32.25h-43v-7.052c0,-7.96575 -6.48225,-14.448 -14.44263,-14.448h-3.35937c-7.96575,0 -14.448,6.48225 -14.448,14.448v7.052h-43c-2.97237,0 -5.375,2.40263 -5.375,5.375c0,2.97237 2.40263,5.375 5.375,5.375h118.25c2.97237,0 5.375,-2.40263 5.375,-5.375c0,-2.97237 -2.40263,-5.375 -5.375,-5.375zM80.625,25.198c0,-2.01025 1.68775,-3.698 3.698,-3.698h3.35938c2.00487,0 3.69262,1.68775 3.69262,3.698v7.052h-10.75z"></path><path d="M72.5625,139.75c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-59.125c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v59.125c0,1.4835 1.204,2.6875 2.6875,2.6875z"></path><path d="M99.4375,139.75c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-59.125c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v59.125c0,1.4835 1.204,2.6875 2.6875,2.6875z"></path></g></g></svg></a>
                                    </div>


                                    <div class="text">

                                        <!-- <p><a href="see_my_courses.php"><span>dellet course</span></a></p> -->

                                        <form method="post" >
                                            <input type="submit" name="delete-resource-btn" value="delete course" style="outline: none; border: none; background-color: transparent; resize: none; font-size: 16px;" />
                                        </form>
                                    </div>





                                </li>
                                 <!-- ToDo: if admin or CC can edit course -->
                                 <li class="course-details__sidebar-meta-list-item">
                                    <div class="icon">
                                        <a href="">
                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                            width="30" height="30"
                                            viewBox="0 0 172 172"
                                            style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#3498db"><path d="M148.35,6.88c-4.28656,0 -8.55969,1.67969 -11.825,4.945l-2.795,2.795l23.65,23.65c-0.01344,0.01344 2.795,-2.795 2.795,-2.795c6.54406,-6.54406 6.53063,-17.11937 0,-23.65c-3.27875,-3.26531 -7.53844,-4.945 -11.825,-4.945zM128.4625,20.7475c-0.77937,0.1075 -1.505,0.49719 -2.0425,1.075l-111.585,111.6925c-0.44344,0.40313 -0.77937,0.92719 -0.9675,1.505l-6.88,25.8c-0.30906,1.1825 0.04031,2.43219 0.90031,3.29219c0.86,0.86 2.10969,1.20938 3.29219,0.90031l25.8,-6.88c0.57781,-0.18812 1.10188,-0.52406 1.505,-0.9675l111.6925,-111.585c1.37063,-1.33031 1.38406,-3.52062 0.05375,-4.89125c-1.33031,-1.37062 -3.52062,-1.38406 -4.89125,-0.05375l-111.0475,111.0475l-13.975,-13.975l111.0475,-111.0475c1.03469,-0.99437 1.34375,-2.53969 0.76594,-3.85656c-0.57781,-1.31687 -1.90812,-2.13656 -3.34594,-2.05594c-0.1075,0 -0.215,0 -0.3225,0z"></path></g></g></svg>
                                         </a>
                                    </div>



                                    <div class="text">

                                        <p><a href="edit_resource.php?resource=' . $rid . '"><span>edit course</span></a></p>
                                    </div>



                                </li>';

}
?>




                        </ul>
                    </div>
                    <div class="course-details__sidebar-meta wow fadeInUp animated mt-3" data-wow-delay="0.3s">


                            <div class="text">
                                <!-- ToDo: Durations of course -->

                                    <?php
$tags = select(QUERY_GET_RESOURCE_TAGS, "i", [$rid]);
if (is_array($tags)) {
    foreach ($tags as $t) {
        echo '<p style="font-size: 16px" ><a href="courses.php?tag=' . $t[0] . '" style="margin: 0px 5px">#' . $t[2] . '</a> </p>';
    }
}
?>



                            </div>

                    </div>


                </div>
            </div>
            <!--End Course Details Sidebar-->
        </div>
    </div>
</section>
<!--End Course Details-->


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


<div class="modal fade bd-example-modal-xl" id="showeExample" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="model-addUser">Example</h5>
                <button type="button" onclick="CloseExample()"   class="btn btn-danger close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body" id="body-modlae">
                <div class="course-details__content-list">
                    <ul class="list-unstyled">
<!--                        TODO:listExample-->
                        <?php
if (is_array($resource_examples)) {
    foreach ($resource_examples as $resource_example) {

        echo '
                            <li>
                            <div class="icon">
                                <span class="icon-confirmation"></span>
                            </div>
                            <div class="text">
                                <a href=' . $resource_example[2] . ' target="_blank">' . $resource_example[1] . '</a>
                            </div>
                        </li>';
    }
}

?>



                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="CloseExample()" class="btn btn-outline-danger" data-dismiss="modal"><i class="flaticon-cancel-12"></i> close</button>
            </div>
        </div>

    </div>

</div>

<div class="mobile-nav__wrapper">
    <div class="mobile-nav__overlay mobile-nav__toggler"></div>
    <!-- /.mobile-nav__overlay -->
    <div class="mobile-nav__content">
        <span class="mobile-nav__close mobile-nav__toggler"><i class="fa fa-times"></i></span>

        <div class="logo-box">
            <a href="index.html" aria-label="logo image"><img src="assetsMainPage/images/resources/mobilemenu_logo.png" width="155" alt="" /></a>
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


<script src="assetsMainPage/vendors/jquery/jquery-3.5.1.min.js"></script>
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
    function showeReportform(){
        $('#report-form').show();
    }
    function showeExample(){
        $('#showeExample').modal('show');
    }
    function CloseExample(){
        $('#showeExample').modal('hide');
    }
    var reported = "<?php echo $report_msg; ?>";
    if(reported){
        showeReportform();
    }
</script>
<?php if (!empty($report_msg)) {
    echo "
    <script>
setTimeout(function (){
    $('#report_msg').hide()

},5000)
</script>
    ";
}
if (!empty($rate_msg)) {
    echo "
    <script>
setTimeout(function (){
    $('#rate_msg').hide()

},5000)
</script>
    ";
}
if (!empty($comment_msg)) {
    echo "
    <script>
setTimeout(function (){
    $('#comment_msg').hide()

},5000)
</script>
    ";
}
?>



</body>

</html>
