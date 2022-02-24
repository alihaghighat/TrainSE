<?php

require_once "../Database/functions.php";
require_once "../Constants/db_queries.php";
//require_once "../functions.php";


if(manipulate(QUERY_ADD_EXAMPLE,"ssi", [ $_POST['TitleExample'],$_POST['LinkExample'],$_POST['courseId'] ]) == 1){
	echo("example successfully added");
}











 ?>