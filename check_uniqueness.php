<?php
require_once "Constants/db_names.php";
require_once "Constants/db_queries.php";
require_once "Database/functions.php";

if (isset($_GET['username'])) {
    $res = select(QUERY_EXIST_USERNAME, "s", [trim($_GET['username'])]);
    if (is_array($res) && sizeof($res) > 0) {
        echo "true";
    } else {
        echo "false";
    }

} else if (isset($_GET['email'])) {
    $res = select(QUERY_EXIST_EMAILS, "s", [trim($_GET['email'])]);
    if (is_array($res) && sizeof($res) > 0) {
        echo "true";
    } else {
        echo "false";
    }
} else {
    echo "false";
}
