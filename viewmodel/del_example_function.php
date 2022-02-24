<?php

require_once "../Database/functions.php";
require_once "../Constants/db_queries.php";
//require_once "../functions.php";


if(manipulate(QUERY_DELETE_EXAMPLE_BY_ID,"i",[intval($_POST['exampleId'])]) == 1){
        echo "example deleted successfully";
    }











 ?>