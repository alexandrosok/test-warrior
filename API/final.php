<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/API/connector.php");

$connector = new Connector();
$conn = $connector->getConnection();
$name = $_REQUEST["name"];
$email = $_REQUEST["email"];
$score = $_REQUEST["score"];

$sql = "INSERT INTO score (score,name,email)VALUES ('$score', '$name','$email')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}