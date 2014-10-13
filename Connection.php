<?php

//Creating Connection
$con = mysqli_connect("localhost","root","","quizdb");

if(!$con) {
	die("Connection Error: ".mysqli_connect_errno." ".mysqli_connect_error());
}

?>