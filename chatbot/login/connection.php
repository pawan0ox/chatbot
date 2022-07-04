<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "chatbot";

$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn){
    die("Error". mysqli_connect_error());
}

?>