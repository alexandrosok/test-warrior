<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/API/connector.php");

$connector = new Connector();
$conn = $connector->getConnection();
$name = $_REQUEST["name"];
$email = $_REQUEST["email"];

$sql = "INSERT INTO email (email,name)VALUES ('$email', '$name')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    $msg = "Someone played your stupid game";
    $msg = wordwrap($msg,70);
    mail("alexandrosok@hotmail.com","Manowarrior",$msg);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}