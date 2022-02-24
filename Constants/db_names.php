<?php

// // DB config
define("DB_NAME", "alihaqiq_trainse");
define("DB_USER", "alihaqiq_trainse_usr");
define("DB_PWD", "7y8WGNNvHgHhsKk");
define("DB_SERVER", "localhost");

// define("DB_NAME", "trainse");
// define("DB_USER", "root");
// define("DB_PWD", "");
// define("DB_SERVER", "localhost");

// Owner config

define("OWNER_USERNAME", "TrainSE5462Owner");
define("OWNER_FIRST_NAME", "Mohammad");
define("OWNER_LAST_NAME", "Eshrati");
define("OWNER_PWD", "123Asd");
define("OWNER_EMAIL", "mohammad79eshrati@gmail.com");

// Database tables
define("DB_TABLE_USER", "user_tbl");
define("DB_TABLE_COMMENT", "comment_tbl");
define("DB_TABLE_ADMIN", "admin_tbl");
define("DB_TABLE_CC", "course_coordinator_tbl");
define("DB_TABLE_STUDENT", "student_tbl");
define("DB_TABLE_RESOURCE", "resource_tbl");
define("DB_TABLE_LIKE", "like_tbl");
define("DB_TABLE_REPORT", "report_tbl");
define("DB_TABLE_RATE", "rate_tbl");
define("DB_TABLE_TOPIC", "topic_tbl");
define("DB_TABLE_FIELD", "field_tbl");
define("DB_TABLE_BOOKMARK", "bookmark_tbl");
define("DB_TABLE_RESOURCE_CREATOR", "resource_creator_tbl");
define("DB_TABLE_SUGGEST_TOPIC", "suggest_topic_tbl");
define("DB_TABLE_SUGGEST_RESOURCE", "suggest_resource_tbl");
define("DB_TABLE_TOPIC_RESOURCE", "topic_resource_tbl");
define("DB_TABLE_STATUS", "status_tbl");
define("DB_TABLE_EXAMPLE", "example_tbl");
define("DB_TABLE_TAG", "tag_tbl");
define("DB_TABLE_RESOURCE_TAG", "resource_tag_tbl");

// Database tables attributes
define("DB_ROLE_STD", "student");
define("DB_ROLE_CC", "cc");
define("DB_ROLE_ADMIN", "admin");
define("DB_ROLE_OWNER", "owner");

// Database report types
define("DB_REPORT_TYPE1", 'Inappropriate Content');
define("DB_REPORT_TYPE2", 'Mismatch Content with the title');

// Database report status
define("DB_REPORT_CHECKED", "Checked");
define("DB_REPORT_IGNORED", "Ignored");

define("DB_SUGGEST_CHECKED", "checked");
define("DB_SUGGEST_UNCHECKED", "unchecked");
