<?php

require_once '../Constants/db_createTableQueries.php';
require_once '../Constants/db_queries.php';
require_once './functions.php';

function create_database()
{

    // creating database
    $conn = new mysqli(DB_SERVER, DB_USER, DB_PWD);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DROP DATABASE IF EXISTS " . constant("DB_NAME") . "";
    if ($conn->query($sql) === true) {
        echo "Database DROPED successfully";
    }

    // Create database
    $sql = "CREATE DATABASE " . constant("DB_NAME") . "";
    if ($conn->query($sql) === true) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . $conn->error;
    }

    $conn->close();
}

function createTableMSG($tbl_name)
{
    echo "<div style=\"font-weight: bold; color : #2FB986\"><br>Table " . $tbl_name . " created successfully</div>";
}

function createTableERR($tbl_name, $err)
{
    echo "<div style=\"font-weight: bold; color : #F66359\"><br>Error creating " . $tbl_name . " table: " . $err . "<br></div>";
}

function createOwnerErr()
{
    echo "<div style=\"font-weight: bold; color : #F66359\"><br>Error : can not add the owner!!!<br></div>";
}

function createOwnerMSG()
{
    echo "<div style=\"font-weight: bold; color : #2FB986\"><br>The owner created successfully</div>";
}

function DB_initialize()
{
    create_database();
    // creating tables
    $conn = new mysqli(DB_SERVER, DB_USER, DB_PWD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($conn->query(USER_TABLE_CREATE_QUERY) === true) {
        createTableMSG(DB_TABLE_USER);
    } else {
        createTableERR(DB_TABLE_USER, $conn->error);
    }

    if ($conn->query(ADMIN_TABLE_CREATE_QUERY) === true) {
        createTableMSG(DB_TABLE_ADMIN);
    } else {
        createTableERR(DB_TABLE_ADMIN, $conn->error);
    }

    if ($conn->query(CC_TABLE_CREATE_QUERY) === true) {
        createTableMSG(DB_TABLE_CC);
    } else {
        createTableERR(DB_TABLE_CC, $conn->error);
    }

    if ($conn->query(STUDENT_TABLE_CREATE_QUERY) === true) {
        createTableMSG(DB_TABLE_STUDENT);
    } else {
        createTableERR(DB_TABLE_STUDENT, $conn->error);
    }

    if ($conn->query(RESOURCE_CREATOR_TABLE_CREATE_QUERY) === true) {
        createTableMSG(DB_TABLE_RESOURCE_CREATOR);
    } else {
        createTableERR(DB_TABLE_RESOURCE_CREATOR, $conn->error);
    }

    if ($conn->query(RESOURCE_TABLE_CREATE_QUERY) === true) {
        createTableMSG(DB_TABLE_RESOURCE);
    } else {
        createTableERR(DB_TABLE_RESOURCE, $conn->error);
    }

    if ($conn->query(COMMENT_TABLE_CREATE_QUERY) === true) {
        createTableMSG(DB_TABLE_COMMENT);
    } else {
        createTableERR(DB_TABLE_COMMENT, $conn->error);
    }

    if ($conn->query(LIKE_TABLE_CREATE_QUERY) === true) {
        createTableMSG(DB_TABLE_LIKE);
    } else {
        createTableERR(DB_TABLE_LIKE, $conn->error);
    }

    if ($conn->query(REPORT_TABLE_CREATE_QUERY) === true) {
        createTableMSG(DB_TABLE_REPORT);
    } else {
        createTableERR(DB_TABLE_REPORT, $conn->error);
    }

    if ($conn->query(RATE_TABLE_CREATE_QUERY) === true) {
        createTableMSG(DB_TABLE_RATE);
    } else {
        createTableERR(DB_TABLE_RATE, $conn->error);
    }

    if ($conn->query(FIELD_TABLE_CREATE_QUERY) === true) {
        createTableMSG(DB_TABLE_FIELD);
    } else {
        createTableERR(DB_TABLE_FIELD, $conn->error);
    }

    if ($conn->query(TOPIC_TABLE_CREATE_QUERY) === true) {
        createTableMSG(DB_TABLE_TOPIC);
    } else {
        createTableERR(DB_TABLE_TOPIC, $conn->error);
    }

    if ($conn->query(BOOKMARK_TABLE_CREATE_QUERY) === true) {
        createTableMSG(DB_TABLE_BOOKMARK);
    } else {
        createTableERR(DB_TABLE_BOOKMARK, $conn->error);
    }

    if ($conn->query(SUGGEST_TOPIC_TABLE_CREATE_QUERY) === true) {
        createTableMSG(DB_TABLE_SUGGEST_TOPIC);
    } else {
        createTableERR(DB_TABLE_SUGGEST_TOPIC, $conn->error);
    }

    if ($conn->query(SUGGEST_RESOURCE_TABLE_CREATE_QUERY) === true) {
        createTableMSG(DB_TABLE_SUGGEST_RESOURCE);
    } else {
        createTableERR(DB_TABLE_SUGGEST_RESOURCE, $conn->error);
    }

    if ($conn->query(TOPIC_RESOURCE_TABLE_CREATE_QUERY) === true) {
        createTableMSG(DB_TABLE_TOPIC_RESOURCE);
    } else {
        createTableERR(DB_TABLE_TOPIC_RESOURCE, $conn->error);
    }

    if ($conn->query(STATUS_CREATE_QUERY) === true) {
        createTableMSG(DB_TABLE_STATUS);
    } else {
        createTableERR(DB_TABLE_STATUS, $conn->error);
    }

    if ($conn->query(EXAMPLE_TABLE_CREATE_QUERY) === true) {
        createTableMSG(DB_TABLE_EXAMPLE);
    } else {
        createTableERR(DB_TABLE_EXAMPLE, $conn->error);
    }

    if ($conn->query(TAG_TABLE_CREATE_QUERY) === true) {
        createTableMSG(TAG_TABLE_CREATE_QUERY);
    } else {
        createTableERR(TAG_TABLE_CREATE_QUERY, $conn->error);
    }

    if ($conn->query(RESOURCE_TAG_CREATE_QUERY) === true) {
        createTableMSG(RESOURCE_TAG_CREATE_QUERY);
    } else {
        createTableERR(RESOURCE_TAG_CREATE_QUERY, $conn->error);
    }

    $conn->close();

    if ((manipulate(QUERY_SIGNUP_USER, "ssssss", [OWNER_USERNAME, OWNER_FIRST_NAME, OWNER_LAST_NAME, OWNER_EMAIL, md5(OWNER_PWD), DB_ROLE_OWNER]) == 1)) {
        if (!manipulate(QUERY_CREATE_ADMIN, "s", [OWNER_USERNAME]) == 1) {
            createOwnerErr();
            return;
        }
    } else {

        createOwnerERR();
        return;

    }
    createOwnerMSG();
}

DB_initialize();
