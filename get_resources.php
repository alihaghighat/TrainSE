<?php
require_once "Constants/db_names.php";
require_once "Constants/db_queries.php";
require_once "Database/functions.php";
if (isset($_GET['q'])) {

    $data = select(QUERY_GET_RESOURCE_BY_DATE, "s", [$_GET['q']]);

    if (is_array($data)) {

        echo json_encode($data, JSON_PRETTY_PRINT);

    } else {
        echo "{}";
    }

} else {
    if (isset($_GET['tag'])) {
        $data = select(QUERY_GET_TAGS_SEARCH, "s", [$_GET['tag']]);

        if (is_array($data)) {

            echo json_encode($data, JSON_PRETTY_PRINT);

        } else {
            echo "{}";
        }
    } else {
        echo "{}";
    }

}
