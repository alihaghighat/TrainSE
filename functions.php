<?php
require_once "./Database/functions.php";
require_once "./Constants/db_queries.php";

function MeanRate($rid)
{
    $rates = select(QUERY_GET_RESOURCE_RATES, "i", [$rid]);
    $sumRate = 0;
    if ($rates == null) {
        return [0, 0];
    }
    foreach ($rates as $r) {
        $sumRate += intval($r[0][0]);
    }

    return [intval($sumRate / sizeof($rates)), sizeof($rates)];
}

function convertToHoursMins($time)
{
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    if ($hours < 1) {
        return sprintf("%dmins", $minutes);
    }
    if ($hours == 1) {
        if ($minutes == 0) {
            return sprintf("%dhr", $hours);
        } else {
            return sprintf("%dhr %dmins", $hours, $minutes);
        }
    }
    if ($minutes == 0) {

        return sprintf("%dhrs", $hours);

    } else {
        return sprintf("%dhrs %dmins", $hours, $minutes);

    }
}

function getTopics($rid)
{
    return select(QUERY_GET_RESOURCE_TOPICS, "i", [$rid]);
}

function getFields($rid)
{
    return select(QUERY_GET_RESOURCE_FIELDS, "i", [$rid]);
}

function fetch_all_users()
{

    return select(QUERY_ALL_USERS, "", []);
}

function dateTostr($date)
{
    $time = strtotime($date);

    $newformat = date('d M, Y', $time);

    return $newformat;
}

function dateTimeTostr($date)
{
    $time = strtotime($date);

    $newformat = date('d M, Y H:i', $time);

    return $newformat;
}

function isRated($username, $rid)
{
    $arr = select("SELECT * FROM " . DB_TABLE_RATE . " WHERE resourceID='" . $rid . "' AND username='" . $username . "' ", "", []);
    return $arr != null;
}

function fetch_topics($field_id)
{
    return select(QUERY_GET_TOPICS, "i", [$field_id]);
}

function findCreator($rid)
{
    $creator = select(QUERY_GET_RESOURCE_CREAETOR, "i", [$rid]);
    if (is_array($creator)) {
        return $creator[0];
    } else {
        return null;
    }
}

function getStdID($username)
{
    $res = select(QUERY_GET_STD_ID, "s", [$username]);
    if ($res != null) {
        return $res[0][0];
    } else {
        return null;
    }
}

function getCCID($username)
{
    $res = select(QUERY_GET_CC_ID, "s", [$username]);
    if ($res != null) {
        return $res[0][0];
    } else {
        return null;
    }
}
function getSTDUsername($sid)
{
    $std = select(QUERY_GET_STD_USERNAME, "i", [$sid]);
    if ($std != null) {
        return $std[0][0];
    } else {
        return null;
    }
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function custom_number_format($n, $precision = 3)
{
    if ($n < 1000) {
        $n_format = number_format($n);
    } else if ($n < 1000000) {
        // Anything less than a million
        $n_format = number_format($n / 1000, $precision) . 'K';
    } else if ($n < 1000000000) {
        // Anything less than a billion
        $n_format = number_format($n / 1000000, $precision) . 'M';
    } else {
        // At least a billion
        $n_format = number_format($n / 1000000000, $precision) . 'B';
    }

    return $n_format;
}
function normalizeURL($text)
{

    $divider = '-';
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

function getRole($username)
{
    $res = select(QUERY_GET_USER_ROLE, "s", [$username]);
    if ($res == null) {
        return null;
    } else {
        return $res[0][0];
    }
}

function getSuggestCount($sid)
{
    $res = select(QUERY_GET_RESOURCE_SUGGEST_COUNT, "i", [$sid]);
    if ($res == null) {
        return null;
    } else {
        return $res[0][0];
    }
}

function getCommentCount($username)
{
    $res = select(QUERY_GET_COMMENT_COUNT, "s", [$username]);
    if ($res == null) {
        return null;
    } else {
        return $res[0][0];
    }
}
function getResourceCount($username)
{
    $res = select(QUERY_GET_USER_RESOURCE_COUNT, "s", [$username]);
    if ($res == null) {
        return null;
    } else {
        return $res[0][0];
    }
}

function getTags($inp)
{
    preg_match_all("~\#(\w+)~i", $inp, $matches);

    return $matches[1];

}
