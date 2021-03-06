<?php

require_once "db_names.php";

define("QUERY_CHECK_USERNAME_EXISTS", "SELECT * FROM " . DB_TABLE_USER . " WHERE 'username' = ? OR 'email' = ? ");
define("QUERY_SIGNUP_USER", "INSERT INTO " . DB_TABLE_USER . " (username, firstName,lastName, email,password,role) VALUES (?, ?, ?, ?, ?, ?) ");
define("QUERY_CREATE_STD", "INSERT INTO " . DB_TABLE_STUDENT . " (username) VALUES (?) ");
define("QUERY_CREATE_ADMIN", "INSERT INTO " . DB_TABLE_ADMIN . " (username) VALUES (?) ");
define("QUERY_CREATE_CC", "INSERT INTO " . DB_TABLE_CC . " (username) VALUES (?) ");
define("QUERY_ALL_USERNAMES", "SELECT username FROM " . DB_TABLE_USER);
define("QUERY_EXIST_USERNAME", "SELECT username FROM " . DB_TABLE_USER . " WHERE username=?");
define("QUERY_ALL_EMAILS", "SELECT email FROM " . DB_TABLE_USER);
define("QUERY_EXIST_EMAILS", "SELECT username FROM " . DB_TABLE_USER . " WHERE email=?");
define("QUERY_LOGIN_USER", "SELECT  username,password,role FROM " . DB_TABLE_USER . " WHERE username=? OR email=? ");
define("QUERY_FETCH_USER_ATTRS_BY_USERNAME", "SELECT * FROM " . DB_TABLE_USER . " WHERE username = ?");
define("QUERY_EDIT_USER_ATTRS", "UPDATE " . DB_TABLE_USER . " SET firstName=?, lastName=?, email=?, imgName=? WHERE username=?");
define("QUERY_EDIT_USER_ATTRS_WITHOUT_IMAGE", "UPDATE " . DB_TABLE_USER . " SET firstName=?, lastName=?, email=? WHERE username=?");
define("QUERY_ADD_FIELD", "INSERT INTO " . DB_TABLE_FIELD . " (date, title, imgName) VALUES (?, ?, ?) ");
define("QUERY_ADD_TOPIC", "INSERT INTO " . DB_TABLE_TOPIC . " (date, fieldID, title, imgName) VALUES (?, ?, ?, ?) ");
define("QUERY_ALL_FIELDS", "SELECT title FROM " . DB_TABLE_FIELD);
define("QUERY_GET_ALL_ADMIN", "SELECT * FROM " . DB_TABLE_ADMIN . " JOIN " . DB_TABLE_USER . " ON " . DB_TABLE_ADMIN . ".username=" . DB_TABLE_USER . ".username ");
define("QUERY_GET_ALL_CC", "SELECT * FROM " . DB_TABLE_CC . " JOIN " . DB_TABLE_USER . " ON " . DB_TABLE_CC . ".username=" . DB_TABLE_USER . ".username ");
define("QUERY_CHANGE_USER_ACCESS", "UPDATE " . DB_TABLE_USER . " SET role=? WHERE username=?");
define("QUERY_GET_ALL_NONADMIN_USERS", "SELECT * FROM " . DB_TABLE_USER . " WHERE username NOT IN(SELECT username FROM " . DB_TABLE_ADMIN . ")");
define("QUERY_GET_ALL_STUDENTS", "SELECT * FROM " . DB_TABLE_USER . " WHERE role=? AND username IN (SELECT username FROM " . DB_TABLE_STUDENT . ") ");
define("QUERY_GET_ALL_FIELDS", "SELECT * FROM " . DB_TABLE_FIELD);
define("QUERY_GET_TOPICS", "SELECT * FROM " . DB_TABLE_TOPIC . " WHERE fieldID=?");
define("QUERY_GET_FIELD_ID_BY_TITLE", "SELECT fieldID FROM " . DB_TABLE_FIELD . " WHERE title = ?");
define("QUERY_ALL_USERS", "SELECT * FROM " . DB_TABLE_USER);
define("QUERY_GET_FIELD_URL", "SELECT imgName FORM " . DB_TABLE_FIELD . " WHERE fieldID=?");
define("QUERY_GET_FIELD", "SELECT * FROM " . DB_TABLE_FIELD . " WHERE fieldID=?");
define("QUERY_GET_FIELD_COURSES", "SELECT * FROM " . DB_TABLE_RESOURCE . "  WHERE resourceID IN ( SELECT resourceID FROM " . DB_TABLE_TOPIC_RESOURCE . " WHERE topicID IN ( SELECT topicID FROM " . DB_TABLE_TOPIC . " WHERE fieldID=?))");
define("QUERY_GET_RESOURCE_CREAETOR", "SELECT * FROM " . DB_TABLE_USER . " WHERE username IN (SELECT username FROM " . DB_TABLE_RESOURCE_CREATOR . " WHERE creatorID IN ( SELECT creatorID FROM " . DB_TABLE_RESOURCE . " WHERE resourceID=?))");
define("QUERY_FETCH_MY_RESOURCES", "SELECT " . DB_TABLE_RESOURCE . ".*," . DB_TABLE_TOPIC . ".title FROM " . DB_TABLE_USER . " JOIN " . DB_TABLE_RESOURCE_CREATOR . " ON " . DB_TABLE_USER . ".username=" . DB_TABLE_RESOURCE_CREATOR . ".username JOIN " . DB_TABLE_RESOURCE . " ON " . DB_TABLE_RESOURCE_CREATOR . ".creatorID=" . DB_TABLE_RESOURCE . ".creatorID JOIN " . DB_TABLE_TOPIC_RESOURCE . " ON " . DB_TABLE_RESOURCE . ".resourceID=" . DB_TABLE_TOPIC_RESOURCE . ".resourceID JOIN " . DB_TABLE_TOPIC . " ON " . DB_TABLE_TOPIC_RESOURCE . ".topicID=" . DB_TABLE_TOPIC . ".topicID ");
define("QUERY_ADD_RESOURCE_CREATOR", "INSERT INTO " . DB_TABLE_RESOURCE_CREATOR . " (username) VALUES (?) ");
define("QUERY_GET_CREATOR_ID_BY_USERNAME", "SELECT creatorID FROM " . DB_TABLE_RESOURCE_CREATOR . " WHERE username = ?");
define("QUERY_ADD_NEW_RESOURCE", "INSERT INTO " . DB_TABLE_RESOURCE . " (title, description,link, imgName,duration,date,creatorID) VALUES (?, ?, ?, ?, ?, ?, ?) ");
define("QUERY_GET_TOPIC_ID_BY_TITLE", "SELECT topicID FROM " . DB_TABLE_TOPIC . " WHERE title = ?");
define("QUERY_GET_RESOURCE_ID_BY_CREATOR_ID", "SELECT resourceID FROM " . DB_TABLE_RESOURCE . " WHERE creatorID = ? ORDER BY date ASC");
define("QUERY_ADD_NEW_TOPIC_RESOURCE", "INSERT INTO " . DB_TABLE_TOPIC_RESOURCE . " (topicID, resourceID) VALUES (?,?) ");
define("QUERY_ALL_TOPICS", "SELECT title FROM " . DB_TABLE_TOPIC);
define("QUERY_GET_RESOURCE_RATES", "SELECT rateLevel FROM " . DB_TABLE_RATE . " WHERE resourceID=?");
define("QUERY_GET_RESOURCE_BY_DATE", "SELECT * FROM " . DB_TABLE_RESOURCE . " WHERE title LIKE CONCAT('%',?,'%') ORDER BY date DESC");
define("QUERY_GET_RESOURCE_TOPICS", "SELECT * FROM " . DB_TABLE_TOPIC . " WHERE topicID IN (SELECT topicID FROM " . DB_TABLE_TOPIC_RESOURCE . " WHERE resourceID=? )");
define("QUERY_GET_RESOURCE_FIELDS", "SELECT * FROM " . DB_TABLE_FIELD . " WHERE fieldID IN (SELECT fieldID FROM " . DB_TABLE_TOPIC . " WHERE topicID IN (SELECT topicID FROM " . DB_TABLE_TOPIC_RESOURCE . " WHERE resourceID=? ))");
define("QUERY_GET_RESOURCE_BY_ID", "SELECT * FROM " . DB_TABLE_RESOURCE . " WHERE resourceID=?");
define("QUERY_ADD_REPORT", "INSERT INTO " . DB_TABLE_REPORT . "(sentDate, type , status , resourceID , username) VALUES ( ? , ? , ? , ? , ?)");
define("QUERY_ADD_RATE", "INSERT INTO " . DB_TABLE_RATE . "(rateLevel, resourceID , username) VALUES ( ? , ? , ?)");
define("QUERY_FETCH_RESOURCE_ATTRS", "SELECT " . DB_TABLE_RESOURCE . ".*," . DB_TABLE_TOPIC . ".title FROM " . DB_TABLE_RESOURCE . " JOIN " . DB_TABLE_TOPIC_RESOURCE . " ON " . DB_TABLE_RESOURCE . ".resourceID=" . DB_TABLE_TOPIC_RESOURCE . ".resourceID JOIN " . DB_TABLE_TOPIC . " ON " . DB_TABLE_TOPIC_RESOURCE . ".topicID=" .
    DB_TABLE_TOPIC . ".topicID WHERE " . DB_TABLE_RESOURCE . ".resourceID=?");
define("QUERY_EDIT_RESOURCE", "UPDATE " . DB_TABLE_RESOURCE . " SET title=?, description=?, link=?, imgName=?, duration=?, date=? WHERE resourceID=?");
define("QUERY_DELETE_RESOURCE_TOPIC", "DELETE FROM " . DB_TABLE_TOPIC_RESOURCE . " WHERE resourceID=?");
define("QUERY_DELETE_RESOURCE", "DELETE FROM " . DB_TABLE_RESOURCE . " WHERE resourceID=?");
define("QUERY_ADD_TO_BOOKMARK", "INSERT INTO " . DB_TABLE_BOOKMARK . " (resourceID, username) VALUES (?,?) ");
define("QUERY_ADD_COMMENT", "INSERT INTO " . DB_TABLE_COMMENT . " (commentText,resourceID, username) VALUES (?,?,?) ");
define("QUERY_FETCH_COMMENTS", "SELECT * FROM " . DB_TABLE_COMMENT . " WHERE resourceID = ?");
define("QUERY_GET_TOP_FIELDS", "SELECT * FROM " . DB_TABLE_FIELD . " JOIN (SELECT fieldID, COUNT(resourceID) as count FROM " . DB_TABLE_TOPIC . " JOIN " . DB_TABLE_TOPIC_RESOURCE . " ON " . DB_TABLE_TOPIC . ".topicID=" . DB_TABLE_TOPIC_RESOURCE . ".topicID GROUP BY " . DB_TABLE_TOPIC . ".fieldID ) as res_count ON " . DB_TABLE_FIELD . ".fieldID=res_count.fieldID ORDER BY res_count.count DESC");
define("QUERY_GET_ALL_REPORT_RESOURCE", "SELECT * FROM " . DB_TABLE_REPORT . " , " . DB_TABLE_RESOURCE . " WHERE " . DB_TABLE_REPORT . ".resourceID=" . DB_TABLE_RESOURCE . ".resourceID ORDER BY status ASC, sentDate DESC");
define("QUERY_CHECK_REPORT", "UPDATE " . DB_TABLE_REPORT . " SET checkoutDate=?, status=?, checker=? WHERE reportID=?");
define("QUERY_CHECK_IF_COMMENT_LIKED", "SELECT * FROM " . DB_TABLE_USER . " JOIN " . DB_TABLE_LIKE . " ON " . DB_TABLE_USER . ".username=" . DB_TABLE_LIKE . ".username JOIN " . DB_TABLE_COMMENT . " ON " . DB_TABLE_LIKE . ".commentID=" . DB_TABLE_COMMENT . ".commentID WHERE " . DB_TABLE_USER . ".username=?");
define("QUERY_ADD_LIKE", "INSERT INTO " . DB_TABLE_LIKE . " (commentID, username) VALUES (?,?) ");
define("QUERY_DELETE_LIKE", "DELETE FROM " . DB_TABLE_LIKE . " WHERE commentID=? AND username=?");
define("QUERY_COUNT_LIKES", "SELECT " . DB_TABLE_LIKE . ".likeID FROM " . DB_TABLE_LIKE . " JOIN " . DB_TABLE_COMMENT . " ON " . DB_TABLE_LIKE . ".commentID=" . DB_TABLE_COMMENT . ".commentID WHERE " . DB_TABLE_LIKE . ".commentID=?");
define("QUERY_GET_RESOURCE_RATE_BY_RESOURCE_ID", "SELECT * FROM " . DB_TABLE_RATE . " WHERE resourceID=?");
define("QUERY_GET_STD_COUNT", "SELECT count(username) FROM " . DB_TABLE_STUDENT . " WHERE username IN (SELECT username FROM " . DB_TABLE_USER . " WHERE role=? )");
define("QUERY_GET_RESOURCE_COUNT", "SELECT count(resourceID) FROM " . DB_TABLE_RESOURCE);
define("QUERY_GET_CC_COUNT", "SELECT count(username) FROM " . DB_TABLE_CC . " WHERE username IN (SELECT username FROM " . DB_TABLE_USER . " WHERE role=? )");
define("QUERY_GET_STD_ID", "SELECT studentID FROM " . DB_TABLE_STUDENT . " WHERE username=? ");
define("QUERY_GET_CC_ID", "SELECT ccID FROM " . DB_TABLE_CC . " WHERE username=? ");
define("QUERY_ADD_NEW_TOPIC_SUGGEST", "INSERT INTO " . DB_TABLE_SUGGEST_TOPIC . " (date, adminID, ccID, topic, field, status, description) VALUES (?,?,?,?,?,?,?) ");
define("QUERY_GET_CC_ID_BY_USERNAME", "SELECT ccID FROM " . DB_TABLE_CC . " WHERE username=?");
define("QUERY_ALL_SUGGESTED_TOPICS", "SELECT * FROM " . DB_TABLE_SUGGEST_TOPIC);
define("QUERY_GET_CC_NAME_BY_ID", "SELECT " . DB_TABLE_USER . ".firstName, " . DB_TABLE_USER . ".lastName FROM " . DB_TABLE_CC . " JOIN " . DB_TABLE_USER . " ON " . DB_TABLE_CC . ".username=" . DB_TABLE_USER . ".username WHERE " . DB_TABLE_CC . ".ccID=?");
define("QUERY_CHECK_TOPIC_SUGGEST", "UPDATE " . DB_TABLE_SUGGEST_TOPIC . " SET status=?, adminID=? WHERE suggestID=?");
define("QUERY_GET_ADMIN_ID_BY_USERNAME", "SELECT adminID FROM " . DB_TABLE_ADMIN . " WHERE username=?");
define("QUERY_FETCH_SUGGEST_TOPIC_ATTRS_BY_ID", "SELECT * FROM " . DB_TABLE_SUGGEST_TOPIC . " WHERE suggestID=?");
define("QUERY_ADD_RESOURCE_SUGGEST", "INSERT INTO " . DB_TABLE_SUGGEST_RESOURCE . "(studentID, link, description) VALUES (?, ?, ?) ");
define("QUERY_GET_ALL_RESOURCE_SUGGEST", "SELECT * FROM " . DB_TABLE_SUGGEST_RESOURCE . " ORDER BY status DESC,date ASC ");
define("QUERY_GET_STD_USERNAME", "SELECT username FROM " . DB_TABLE_STUDENT . " WHERE studentID=?");
define("QUERY_CHECK_RESOURCE_SUGGEST", "UPDATE " . DB_TABLE_SUGGEST_RESOURCE . " SET status=?, ccID=? WHERE suggestID=?");
define("QUERY_CHECK_IF_BOOKMARKED", "SELECT username FROM " . DB_TABLE_BOOKMARK . " WHERE resourceID=?");
define("QUERY_REMOVE_BOOKMARK", "DELETE FROM " . DB_TABLE_BOOKMARK . " WHERE resourceID=? AND username=?");
define("QUERY_FETCH_BOOKMARKS", "SELECT " . DB_TABLE_RESOURCE . ".* FROM " . DB_TABLE_USER . " JOIN " . DB_TABLE_BOOKMARK . " ON " . DB_TABLE_USER . ".username=" . DB_TABLE_BOOKMARK . ".username JOIN " . DB_TABLE_RESOURCE . " ON " . DB_TABLE_BOOKMARK . ".resourceID=" . DB_TABLE_RESOURCE . ".resourceID WHERE " . DB_TABLE_USER . ".username=?");
define("QUERY_GET_USER_ROLE", "SELECT role FROM " . DB_TABLE_USER . " WHERE username=?");
define("QUERY_GET_COMMENT_COUNT", "SELECT COUNT(commentID) FROM " . DB_TABLE_COMMENT . " WHERE username=?");
define("QUERY_GET_RESOURCE_SUGGEST_COUNT", "SELECT COUNT(suggestID) FROM " . DB_TABLE_SUGGEST_RESOURCE . " WHERE studentID=?");
define("QUERY_GET_USER_RESOURCE_COUNT", "SELECT COUNT(resourceID) FROM " . DB_TABLE_RESOURCE . " WHERE creatorID IN (SELECT creatorID FROM " . DB_TABLE_RESOURCE_CREATOR . " WHERE username=?)");
define("QUERY_ADD_EXAMPLE", "INSERT INTO " . DB_TABLE_EXAMPLE . " (title, link, resourceID) VALUES (?, ?, ?)");
define("QUERY_GET_EXAMPLES_BY_RESOURCE_ID", "SELECT * FROM " . DB_TABLE_EXAMPLE . " WHERE resourceID=?");
define("QUERY_DELETE_EXAMPLE_BY_ID", "DELETE FROM " . DB_TABLE_EXAMPLE . " WHERE exampleID=?");
define("QUERY_GET_SAME_TAGS", "SELECT * FROM " . DB_TABLE_TAG . " WHERE title=?");
define("QUERY_SET_RESOURCE_TAG", "INSERT INTO " . DB_TABLE_RESOURCE_TAG . "(tagID, resourceID) VALUES (?, ?)");
define("QUERY_ADD_TAG", "INSERT INTO " . DB_TABLE_TAG . "(title) VALUES (?)");
define("QUERY_GET_RESOURCE_TAGS", "SELECT * FROM " . DB_TABLE_TAG . " WHERE tagID IN (SELECT tagID FROM " . DB_TABLE_RESOURCE_TAG . " WHERE resourceID=?)");
define("QUERY_GET_TAG_RESOURCES", "SELECT * FROM " . DB_TABLE_RESOURCE . " WHERE resourceID IN (SELECT resourceID FROM " . DB_TABLE_RESOURCE_TAG . " WHERE tagID=?)");
define("QUERY_GET_TAG_BY_ID", "SELECT * FROM " . DB_TABLE_TAG . " WHERE tagID=?");
define("QUERY_GET_TAGS_SEARCH", "SELECT * FROM " . DB_TABLE_TAG . " WHERE title LIKE  CONCAT('%',?,'%')");
define("QUERY_HAS_TAG", "SELECT resourceID FROM " . DB_TABLE_RESOURCE_TAG . " WHERE tagID=?");
define("QUERY_GET_TOPIC_BY_ID", "SELECT * FROM " . DB_TABLE_TOPIC . " WHERE topicID=?");
define("QUERY_GET_TOPIC_RESOURCES", "SELECT * FROM " . DB_TABLE_RESOURCE . " WHERE resourceID IN (SELECT resourceID FROM " . DB_TABLE_TOPIC_RESOURCE . " WHERE topicID=?)");
define("QUERY_GET_SEARCH_TAG_RESOURCES", "SELECT * FROM " . DB_TABLE_RESOURCE . " WHERE resourceID IN (SELECT resourceID FROM " . DB_TABLE_RESOURCE_TAG . " WHERE tagID IN (SELECT tagID FROM " . DB_TABLE_TAG . " WHERE title LIKE  CONCAT('%',?,'%')))");
define("QUERY_DELETE_RESOURCE_TAGS", "DELETE FROM " . DB_TABLE_RESOURCE_TAG . " WHERE resourceID=?");
