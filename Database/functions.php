<?php

function alert($message)
{
    echo '<script >alert("' . $message . '");</script>';
}

function manipulate($query, $pattern, $params)
{
    $conn = new mysqli(DB_SERVER, DB_USER, DB_PWD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        return 0; // return 0 for error
    }

    $stmt = $conn->prepare($query);
    if (gettype($stmt) == gettype(false)) {
        alert("There is something wrong with query : " . $query);
        return null;
    }

    $sqldata = [];
    for ($i = 0; $i < sizeof($params); $i++) {
        $sqldata[] = &$params[$i];
    }

    if (sizeof($params) > 0) {
        array_unshift($sqldata, $pattern); // prepend the types
        call_user_func_array([$stmt, 'bind_param'], $sqldata);
    }
    $stmt->execute();

    $stmt->close();
    $conn->close();
    return 1; // return 1 for success

}

function select($query, $pattern, $params)
{
    $conn = new mysqli(DB_SERVER, DB_USER, DB_PWD, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    mysqli_set_charset($conn, 'utf8mb4');

    $stmt = $conn->prepare($query);

    $sqldata = [];
    foreach ($params as $data) {
        $sqldata[] = &$data; // MUST be a reference
    }

    if (gettype($stmt) == gettype(false)) {
        alert("There is something wrong with query : " . $query);
        return null;
    }

    if (sizeof($params) > 0) {
        array_unshift($sqldata, $pattern); // prepend the types
        call_user_func_array([$stmt, 'bind_param'], $sqldata);
    }

    $stmt->execute();

    $result = $stmt->get_result();

    if (gettype($result) == gettype(false)) {
        alert("There is something wrong with query : " . $query);
        return null;
    }
    $conn->close();

    if ($result->num_rows > 0) {

        return $result->fetch_all();

    } else {
        return null;
    }

}
