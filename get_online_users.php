<?php
require_once "Database/functions.php";
require_once "Constants/db_names.php";

error_reporting(E_ERROR | E_PARSE);

$session = session_id();
$time = time();
$time_check = $time - 600;
$result = select("SELECT * FROM " . DB_TABLE_STATUS . " WHERE session=?", "s", [$session]);
if ($result == null) {
    $count = 0;
} else {
    $count = sizeof($result);
}

if ($count == 0) {
    $result1 = manipulate("INSERT INTO " . DB_TABLE_STATUS . "(session, time)VALUES(?, ?)", "si", [$session, $time]);
} else {
    $result2 = manipulate("UPDATE " . DB_TABLE_STATUS . " SET time=? WHERE session = ?", "is", [$time, $session]);
}
$result3 = select("SELECT * FROM " . DB_TABLE_STATUS, "", []);
if ($result3 === null) {
    $count_user_online = 0;

} else {
    $count_user_online = sizeof($result3);

}

$result4 = manipulate("DELETE FROM " . DB_TABLE_STATUS . " WHERE time<?", "i", [$time_check]);
